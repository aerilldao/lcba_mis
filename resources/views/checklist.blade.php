<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCBA - Checklist</title>
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
            top: 82px; /* Adjusted based on header height */
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
            margin-top: 150px; /* Space for both navbars */
            padding: 2rem;
            width: 100%;
            max-width: 1400px;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            margin-left: auto;
            margin-right: auto;
        }

        .input-group {
            margin-bottom: 1.5rem;
            max-width: 300px;
        }

        .input-group label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .input-group input {
            width: 100%;
            padding: 0.8rem 1.2rem;
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 10px;
            outline: none;
            font-family: inherit;
            font-size: 1rem;
            color: var(--text-main);
            background: #ffffff;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-group input:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .form-section-title {
            color: var(--primary-color);
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(30, 58, 138, 0.1);
            grid-column: 1 / -1;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 3rem;
            width: 100%;
            max-width: 800px;
        }

        .form-column {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .sub-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .input-group.full-width {
            max-width: 100%;
        }

        .field-row {
            display: grid;
            gap: 1.5rem;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .section-label {
            min-width: 220px;
            font-weight: 800;
            color: var(--primary-color);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            display: flex;
            align-items: flex-start;
            padding-top: 0; /* Align with input titles */
            margin-top: 2px; /* Fine-tune baseline alignment with lighter labels */
        }

        .field-container {
            display: grid;
            gap: 1.5rem;
            flex: 1;
        }

        @media (max-width: 1024px) {
            .field-row {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 768px) {
            .sub-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Custom Scrollbar Styles */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(30, 58, 138, 0.2);
            border-radius: 20px;
            border: 2px solid #f8fafc;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }

        html {
            scroll-behavior: smooth;
            overflow-y: scroll !important; /* Force scrollbar */
            height: auto !important;
        }

        body {
            display: block !important;
            height: auto !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            min-height: 100vh;
        }
    </style>
</head>
<body style="background-color: #f8fafc; display: block !important; overflow-y: auto !important; margin: 0; padding: 0;">
    <!-- Main Header -->
    <nav class="checklist-nav">
        <div class="checklist-nav-left">
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="LCBA Logo" class="checklist-nav-logo">
            <h1>CHECKLIST</h1>
        </div>
        
        <a href="{{ route('dashboard') }}" class="btn-back" style="text-decoration: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Back to Dashboard
        </a>
    </nav>

    <!-- Sub Navbar -->
    <div class="sub-navbar">
        <span>Basic Information</span>
    </div>

    <!-- Main Content -->
    <main class="checklist-content">
        <div class="card" style="width: 100%; padding: 2.5rem; max-width: 100%;">
            
            <div class="form-grid" style="max-width: 100%;">
                <!-- ID/Header Section -->
                <div class="input-group">
                    <label for="id_no">ID NO</label>
                    <input type="text" id="id_no" name="id_no" placeholder="Enter ID Number">
                </div>

                <!-- Student Information -->
                <div class="form-column">
                    <h3 class="form-section-title">Student Information</h3>
                    <div class="field-row" style="grid-template-columns: 220px 1fr;">
                        <span class="section-label">FULL NAME</span>
                        <div class="field-container" style="grid-template-columns: repeat(4, 1fr);">
                            <div class="input-group full-width">
                                <label>Last Name</label>
                                <input type="text" name="student_last_name" placeholder="Last Name">
                            </div>
                            <div class="input-group full-width">
                                <label>First Name</label>
                                <input type="text" name="student_first_name" placeholder="First Name">
                            </div>
                            <div class="input-group full-width">
                                <label>Middle Name</label>
                                <input type="text" name="student_middle_name" placeholder="Middle Name">
                            </div>
                            <div class="input-group full-width">
                                <label>Suffix</label>
                                <input type="text" name="student_suffix" placeholder="Jr., III, etc.">
                            </div>
                        </div>
                    </div>
                    <div class="field-row" style="grid-template-columns: 220px 1fr;">
                        <span class="section-label">OTHER DETAILS</span>
                        <div class="field-container" style="grid-template-columns: repeat(3, 1fr);">
                            <div class="input-group full-width">
                                <label>Birthdate</label>
                                <input type="date" name="student_birthdate">
                            </div>
                            <div class="input-group full-width">
                                <label>Sex</label>
                                <input type="text" name="student_sex" placeholder="Male / Female">
                            </div>
                            <div class="input-group full-width">
                                <label>Age</label>
                                <input type="number" name="student_age" placeholder="Age">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="form-column">
                    <h3 class="form-section-title">Address Information</h3>
                    <div class="field-row" style="grid-template-columns: 220px 1fr;">
                        <span class="section-label">ADDRESS</span>
                        <div class="field-container" style="grid-template-columns: repeat(4, 1fr);">
                            <div class="input-group full-width">
                                <label>House No.</label>
                                <input type="text" name="house_no" placeholder="House No.">
                            </div>
                            <div class="input-group full-width">
                                <label>Street Name</label>
                                <input type="text" name="street_name" placeholder="Street Name">
                            </div>
                            <div class="input-group full-width">
                                <label>Barangay</label>
                                <input type="text" name="barangay" placeholder="Barangay">
                            </div>
                            <div class="input-group full-width">
                                <label>Zip Code</label>
                                <input type="text" name="zip_code" placeholder="Zip Code">
                            </div>
                        </div>
                    </div>
                    <div class="field-row" style="grid-template-columns: 220px 1fr;">
                        <div style="grid-column: 2;">
                            <div class="field-container" style="grid-template-columns: repeat(3, 1fr);">
                                <div class="input-group full-width">
                                    <label>Municipality / City</label>
                                    <input type="text" name="municipality_city" placeholder="Municipality / City">
                                </div>
                                <div class="input-group full-width">
                                    <label>Province</label>
                                    <input type="text" name="province" placeholder="Province">
                                </div>
                                <div class="input-group full-width">
                                    <label>Country</label>
                                    <input type="text" name="country" value="Philippines">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Father's Information -->
                <div class="form-column">
                    <h3 class="form-section-title">Father's Information</h3>
                    <div class="field-row" style="grid-template-columns: 220px 1fr;">
                        <span class="section-label">FATHER'S NAME</span>
                        <div class="field-container" style="grid-template-columns: repeat(4, 1fr);">
                            <div class="input-group full-width">
                                <label>Last Name</label>
                                <input type="text" name="father_last_name" placeholder="Last Name">
                            </div>
                            <div class="input-group full-width">
                                <label>First Name</label>
                                <input type="text" name="father_first_name" placeholder="First Name">
                            </div>
                            <div class="input-group full-width">
                                <label>Middle Name</label>
                                <input type="text" name="father_middle_name" placeholder="Middle Name">
                            </div>
                            <div class="input-group full-width">
                                <label>Suffix</label>
                                <input type="text" name="father_suffix" placeholder="Suffix">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mother's Information -->
                <div class="form-column">
                    <h3 class="form-section-title">Mother's Information</h3>
                    <div class="field-row" style="grid-template-columns: 220px 1fr;">
                        <span class="section-label">MOTHER'S NAME</span>
                        <div class="field-container" style="grid-template-columns: repeat(4, 1fr);">
                            <div class="input-group full-width">
                                <label>Last Name</label>
                                <input type="text" name="mother_last_name" placeholder="Last Name">
                            </div>
                            <div class="input-group full-width">
                                <label>First Name</label>
                                <input type="text" name="mother_first_name" placeholder="First Name">
                            </div>
                            <div class="input-group full-width">
                                <label>Middle Name</label>
                                <input type="text" name="mother_middle_name" placeholder="Middle Name">
                            </div>
                            <div class="input-group full-width">
                                <label>Suffix</label>
                                <input type="text" name="mother_suffix" placeholder="Suffix">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guardian Information -->
                <div class="form-column">
                    <h3 class="form-section-title">Guardian's Information</h3>
                    <div class="field-row" style="grid-template-columns: 220px 1fr;">
                        <span class="section-label">GUARDIAN'S NAME</span>
                        <div class="field-container" style="grid-template-columns: repeat(5, 1fr);">
                            <div class="input-group full-width">
                                <label>Last Name</label>
                                <input type="text" name="guardian_last_name" placeholder="Last Name">
                            </div>
                            <div class="input-group full-width">
                                <label>First Name</label>
                                <input type="text" name="guardian_first_name" placeholder="First Name">
                            </div>
                            <div class="input-group full-width">
                                <label>Middle Name</label>
                                <input type="text" name="guardian_middle_name" placeholder="Middle Name">
                            </div>
                            <div class="input-group full-width">
                                <label>Suffix</label>
                                <input type="text" name="guardian_suffix" placeholder="Suffix">
                            </div>
                            <div class="input-group full-width">
                                <label>Contact Number</label>
                                <input type="text" name="guardian_contact" placeholder="Contact">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div style="margin-top: 3rem; display: flex; justify-content: flex-end; gap: 1rem;">
                <button type="reset" class="btn-back" style="background: rgba(0,0,0,0.05); padding: 0.8rem 2rem;">Clear All</button>
                <button type="submit" class="btn-login" style="padding: 0.8rem 3rem;">Save Information</button>
            </div>

        </div>
    </main>
</body>
</html>
