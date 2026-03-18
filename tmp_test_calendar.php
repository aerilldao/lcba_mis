<?php
use App\Models\User;
use App\Models\CalendarEvent;
use Illuminate\Support\Facades\DB;

echo "--- CALENDAR LOGIC TEST ---\n\n";

$superUser = User::where('email', 'SUPERUSER')->first();
$user1 = User::where('name', 'like', '%User 1%')->orWhere('email', 'like', '%user1%')->first();
$user2 = User::where('name', 'like', '%User 2%')->orWhere('email', 'like', '%user2%')->first();

if (!$user1) {
    // try to get any non-superuser
    $users = User::where('email', '!=', 'SUPERUSER')->take(2)->get();
    $user1 = $users[0] ?? null;
    $user2 = $users[1] ?? null;
}

if (!$superUser || !$user1 || !$user2) {
    echo "Missing users to test. Found:\n";
    echo "Superuser: " . ($superUser ? "Yes" : "No") . "\n";
    echo "User 1: " . ($user1 ? $user1->name : "No") . "\n";
    echo "User 2: " . ($user2 ? $user2->name : "No") . "\n";
    exit;
}

echo "Testing with:\n";
echo "Superuser: {$superUser->name}\n";
echo "User A: {$user1->name}\n";
echo "User B: {$user2->name}\n\n";

// Clear previous test events to be clean
CalendarEvent::whereIn('title', ['Global Test Event', 'Super Private', 'User A Private'])->delete();

echo "1. Creating Global Event authored by SU...\n";
CalendarEvent::create([
    'user_id' => $superUser->id,
    'title' => 'Global Test Event',
    'event_date' => '2026-03-20',
    'is_global' => true
]);

echo "2. Creating Private Event authored by SU...\n";
CalendarEvent::create([
    'user_id' => $superUser->id,
    'title' => 'Super Private',
    'event_date' => '2026-03-21',
    'is_global' => false
]);

echo "3. Creating Private Event authored by User A...\n";
CalendarEvent::create([
    'user_id' => $user1->id,
    'title' => 'User A Private',
    'event_date' => '2026-03-22',
    'is_global' => false
]);

echo "\n--- VERIFYING QUERIES ---\n\n";

function getEventsForUser($userId) {
    return CalendarEvent::where(function($q) use ($userId) {
        $q->where('user_id', $userId)
          ->orWhere('is_global', true);
    })->get()->pluck('title')->toArray();
}

echo "Events visible to User A ({$user1->name}):\n";
print_r(getEventsForUser($user1->id));

echo "\nEvents visible to User B ({$user2->name}):\n";
print_r(getEventsForUser($user2->id));

echo "\nEvents visible to Superuser ({$superUser->name}):\n";
print_r(getEventsForUser($superUser->id));

echo "\nTest Completed.\n";
