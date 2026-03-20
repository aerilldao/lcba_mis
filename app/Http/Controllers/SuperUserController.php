<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CalendarEvent;
use Illuminate\Support\Facades\Auth;

class SuperUserController extends Controller
{
    public function index()
    {
        if (Auth::user()->email !== 'SUPERUSER') {
            return redirect('/dashboard');
        }

        $totalUsers = User::count();
        $totalEvents = CalendarEvent::count();
        
        // Fetch all users with status
        $users = User::orderBy('last_activity_at', 'desc')->get()->map(function($user) {
            $user->is_online = $user->last_activity_at && $user->last_activity_at->gt(now()->subMinutes(5));
            return $user;
        });

        $activeUsersCount = $users->where('is_online', true)->count();

        return view('superuser.dashboard', compact('totalUsers', 'totalEvents', 'users', 'activeUsersCount'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['status' => 'success', 'user' => $user]);
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $data = $request->only(['name', 'email']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return response()->json(['status' => 'success', 'user' => $user]);
    }

    public function deleteUser(User $user)
    {
        if ($user->email === 'SUPERUSER') {
            return response()->json(['error' => 'Cannot delete super user'], 403);
        }

        $user->delete();
        return response()->json(['status' => 'success']);
    }



    public function killSession(User $user)
    {
        if (Auth::user()->email !== 'SUPERUSER') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($user->email === 'SUPERUSER') {
            return response()->json(['error' => 'Cannot kill super user session'], 403);
        }

        // Delete all active sessions for this user from the sessions table
        \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', $user->id)
            ->delete();

        // Invalidate remember token to prevent automatic re-login
        // and reset activity tracking
        $user->forceFill([
            'remember_token' => \Illuminate\Support\Str::random(60),
            'last_activity_at' => null
        ])->save();

        return response()->json(['status' => 'success']);
    }

    public function getAuditData()
    {
        if (Auth::user()->email !== 'SUPERUSER') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $users = User::all()->map(function($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->email === 'SUPERUSER' ? 'ROOT COMMAND' : 'STAFF ACCESS',
                'joined' => $user->created_at->format('Y-m-d'),
                'password_status' => 'SECURE (BCRYPT)'
            ];
        });

        return response()->json($users);
    }

    public function exportRegistry()
    {
        if (Auth::user()->email !== 'SUPERUSER') {
            abort(403);
        }

        try {
            // Force visibility of hidden fields for the dump
            $users = User::all()->makeVisible(['password', 'remember_token']);
            $events = CalendarEvent::all();
            $students = \App\Models\StudentInfo::all();
            $enrollments = \App\Models\EnrollmentRecord::all();

            $sql = "-- LCBA MIS - System Registry Export\n";
            $sql .= "-- Generated: " . now()->toDateTimeString() . "\n";
            $sql .= "-- Tables: users, calendar_events, student_info, enrollment_records\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

            // Helper to generate INSERT statements
            $generateInserts = function($collection, $tableName) {
                $output = "--\n-- Exporting Data for Table: $tableName\n--\n";
                foreach ($collection as $model) {
                    $attrs = $model->getAttributes();
                    $columns = array_keys($attrs);
                    $values = array_map(function($val) {
                        if (is_null($val)) return 'NULL';
                        if (is_numeric($val) && !is_string($val)) return $val;
                        return "'" . str_replace(["'", "\n", "\r"], ["''", "\\n", "\\r"], $val) . "'";
                    }, array_values($attrs));

                    $output .= "INSERT INTO $tableName (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ") ON DUPLICATE KEY UPDATE id=id;\n";
                }
                return $output . "\n";
            };

            $sql .= $generateInserts($users, 'users');
            $sql .= $generateInserts($events, 'calendar_events');
            $sql .= $generateInserts($students, 'student_info');
            $sql .= $generateInserts($enrollments, 'enrollment_records');

            $sql .= "\nSET FOREIGN_KEY_CHECKS = 1;\n";

            $filename = 'lcba_registry_dump_' . now()->format('Y-m-d_His') . '.sql';
            
            return response()->streamDownload(function () use ($sql) {
                echo $sql;
            }, $filename, [
                'Content-Type' => 'application/x-sql',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'SQL Export failed: ' . $e->getMessage());
        }
    }
}
