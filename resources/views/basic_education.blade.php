<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCBA - Basic Education</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <style>
        .checklist-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 1rem 2rem;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
        }

        .checklist-nav-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .checklist-nav-logo {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .checklist-nav h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
            letter-spacing: 0.05em;
            margin: 0;
        }

        .sub-navbar {
            background: var(--primary-color);
            width: 100%;
            padding: 0.75rem 2rem;
            color: white;
            position: fixed;
            top: 82px;
            left: 0;
            z-index: 40;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .sub-navbar span {
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .checklist-content {
            margin-top: 150px;
            padding: 2rem;
            width: 100%;
            max-width: 1400px;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-left: auto;
            margin-right: auto;
        }

        .section-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 2rem;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .section-title {
            color: var(--primary-color);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 2rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(30, 58, 138, 0.1);
        }

        .field-row {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            margin-bottom: 2rem;
            align-items: flex-start;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
        }

        .field label {
            font-weight: 800;
            font-size: 0.75rem;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .field input[type="text"],
        .field input[type="number"],
        .field select {
            width: 100%;
            padding: 0.8rem 1.2rem;
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 10px;
            outline: none;
            font-family: inherit;
            font-size: 1rem;
            background: #ffffff;
            appearance: none;
        }

        .field select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.2em;
        }

        .checkbox-group {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .checkbox-item input {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .checkbox-item span {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-main);
            text-transform: uppercase;
        }



        .section-label {
            min-width: 200px;
            font-weight: 800;
            color: var(--primary-color);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            padding-top: 0.5rem;
        }

        .layout-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
            align-items: flex-start;
        }

        @media (max-width: 1200px) {
            .layout-grid {
                grid-template-columns: 1fr;
            }
        }

        .credentials-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.85rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .credentials-item:last-child {
            border-bottom: none;
        }

        .credentials-item span {
            font-weight: 600;
            font-size: 0.82rem;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .credentials-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
    </style>
</head>
<body style="background-color: #f8fafc; display: block; overflow-y: auto;">

    <!-- Main Header -->
    <nav class="checklist-nav">
        <div class="checklist-nav-left">
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="LCBA Logo" class="checklist-nav-logo">
            <h1>CHECKLIST</h1>
        </div>
        <a href="{{ route('checklist') }}" class="btn-back" style="text-decoration: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Back to Checklist
        </a>
    </nav>

    <!-- Sub Navbar -->
    <div class="sub-navbar">
        <span>Basic Education</span>
    </div>

    <!-- Main Content -->
    <main class="checklist-content">
        
        <div class="layout-grid">
            <div class="section-card">
                <div class="section-title">Educational Background & Enrollment Details</div>

                <!-- Checkboxes Row -->
                <div class="field-row">
                    <div class="checkbox-group">
                        <label class="checkbox-item">
                            <input type="checkbox" name="balik_aral">
                            <span>TICK IF BALIK ARAL</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="senior_high">
                            <span>TICK IF SENIOR HIGH</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="freshman">
                            <span>FRESHMAN</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="transferee">
                            <span>TRANSFEREE</span>
                        </label>
                    </div>
                </div>

                <!-- Grade Level / LRN / ECS Row -->
                <div class="field-row">
                    <div class="field">
                        <label>GRADE LEVEL</label>
                        <input type="text" name="grade_level" placeholder="Enter Grade Level">
                    </div>
                    <div class="field">
                        <label>LRN(ONLY IF APPLICABLE)</label>
                        <input type="text" name="lrn" placeholder="Enter LRN">
                    </div>
                    <div class="field">
                        <label>ECS(ONLY IF APPLICABLE)</label>
                        <input type="text" name="ecs" placeholder="Enter ECS">
                    </div>
                </div>

                <!-- Strand Row -->
                <div class="field-row">
                    <div class="field">
                        <label>STRAND</label>
                        <input type="text" name="strand" placeholder="Enter Strand">
                    </div>
                </div>

                <!-- Semester Row -->
                <div class="field-row">
                    <div class="field" style="max-width: 400px;">
                        <label>SEMESTER</label>
                        <select name="semester">
                            <option value="" disabled selected>Select Semester</option>
                            <option value="1st">1ST SEMESTER</option>
                            <option value="2nd">2ND SEMESTER</option>
                        </select>
                    </div>
                </div>

                <!-- School Last Attended Row -->
                <div class="field-row">
                    <div class="field">
                        <label>SCHOOL LAST ATTENDED</label>
                        <div style="display: flex; gap: 1.5rem; width: 100%; margin-top: 1rem;">
                            <div class="field">
                                <label>SCHOOL NAME</label>
                                <input type="text" name="school_name" placeholder="Enter School Name">
                            </div>
                            <div class="field">
                                <label>LAST SCHOOL YEAR</label>
                                <input type="text" name="last_school_year" placeholder="e.g. 2023-2024">
                            </div>
                            <div class="field">
                                <label>LAST GRADE LEVEL</label>
                                <input type="text" name="last_grade_level" placeholder="Enter Last Grade Level">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- School ID Row -->
                <div class="field-row">
                    <div class="field" style="max-width: calc(25% - 1.5rem);">
                        <label>SCHOOL ID</label>
                        <input type="text" name="school_id" placeholder="Enter School ID">
                    </div>
                    <!-- Empty space for the rest of the row -->
                    <div style="flex: 3;"></div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                    <button type="reset" class="btn-back" style="background: rgba(0,0,0,0.05); padding: 0.8rem 2rem;">Clear All</button>
                    <button type="submit" class="btn-login" style="padding: 0.8rem 3rem;">Submit</button>
                </div>
            </div>

            <div class="section-card">
                <div class="section-title">CREDENTIALS CHECK</div>
                <div class="credentials-list">
                    <div class="credentials-item">
                        <span>FORM 138</span>
                        <input type="checkbox" name="credential_138">
                    </div>
                    <div class="credentials-item">
                        <span>FORM 137-A</span>
                        <input type="checkbox" name="credential_137a">
                    </div>
                    <div class="credentials-item">
                        <span>GOOD MORALE</span>
                        <input type="checkbox" name="credential_moral">
                    </div>
                    <div class="credentials-item">
                        <span>PICTURES</span>
                        <input type="checkbox" name="credential_pics">
                    </div>
                    <div class="credentials-item">
                        <span>PSA (PHOTOCOPY)</span>
                        <input type="checkbox" name="credential_psa">
                    </div>
                    <div class="credentials-item">
                        <span>TRANSFER CREDENTIALS</span>
                        <input type="checkbox" name="credential_transfer">
                    </div>
                    <div class="credentials-item">
                        <span>TRANSCRIPT OF RECORDS</span>
                        <input type="checkbox" name="credential_tor">
                    </div>
                </div>
            </div>
        </div>

    </main>


</body>
</html>
