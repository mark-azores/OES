
<aside class="main-sidebar sidebar-light-success elevation-4">
    <a href="#" class="brand-link bg-success">
        <img src="assets/logo.jpg" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Lake Shore Edu. Ins.</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-flat nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-header">HOME</li>
                <li class="nav-item">
                    <a href="home.php" class="nav-link <?php echo $title == 'Home' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="instructors.php" class="nav-link <?php echo $title == 'Instructors' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p> Instructors </p>
                    </a>
                </li>

                <li class="nav-header">STUDENTS</li>
                <li class="nav-item <?php echo $title == 'Strands' 
                    || $title == 'SH Section' 
                    || $title == 'SH Enrolled Students' 
                    || $title == 'SH Enrollees Applicants' 
                    || $title == 'SH Rejected Applicants'  
                    || $title == 'SH Rejected Applicants'  
                    ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?php echo $title == 'Strands' 
                        || $title == 'SH Section' 
                        || $title == 'SH Enrolled Students'
                        || $title == 'SH Enrollees Applicants'  
                        || $title == 'SH Rejected Applicants'  
                        ? 'active' : '' ?>">
                        <i class="nav-icon fa fa-university"></i>
                        <p>
                            Senior High
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="strands.php" class="nav-link <?php echo $title == 'Strands' ? 'active' : '' ?>">
                                <i class="fa fa-th nav-icon"></i>
                                <p>Strands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sh_section.php" class="nav-link <?php echo $title == 'SH Section' ? 'active' : '' ?>">
                                <i class="fa fa-list-alt nav-icon"></i>
                                <p>Section</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sh_enrolled.php" class="nav-link <?php echo $title == 'SH Enrolled Students' ? 'active' : '' ?>">
                                <i class="fa fa-user-check nav-icon"></i>
                                <p>Enrolled Students</p>
                            </a>
                        </li>
                        
                        <li class="nav-item <?php echo 
                            $title == 'SH Enrollees Applicants' 
                            || $title == 'SH Rejected Applicants'  
                            ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?php echo 
                                $title == 'SH Enrollees Applicants' 
                                || $title == 'SH Rejected Applicants'  
                                ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                Applicants
                                    <span class="badge badge-success">
                                        <?php echo get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE 
                                        WHERE status IN ('Scheduled','Pending') AND grade_level BETWEEN 11 AND 12 "); ?>
                                    </span>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="sh_enrollees.php" class="nav-link <?php echo $title == 'SH Enrollees Applicants' ? 'active' : '' ?>">
                                        <i class="fa fa-user-plus nav-icon"></i>
                                        <p>Registrants</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="sh_rejected.php" class="nav-link <?php echo $title == 'SH Rejected Applicants' ? 'active' : '' ?>">
                                        <i class="fa fa-user-times nav-icon"></i>
                                        <p>Rejected</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                    </ul>
                </li>

                <li class="nav-item <?php echo $title == 'JH Section' 
                    || $title == 'JH Enrolled Students' 
                    || $title == 'JH Enrollees Applicants' 
                    || $title == 'JH Rejected Applicants'  
                    ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?php echo $title == 'JH Section' 
                        || $title == 'JH Enrolled Students'
                        || $title == 'JH Enrollees Applicants' 
                        || $title == 'JH Rejected Applicants'  
                        ? 'active' : '' ?>">
                        <i class="nav-icon fa fa-school"></i>
                        <p>
                            Junior High
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="jh_section.php" class="nav-link <?php echo $title == 'JH Section' ? 'active' : '' ?>">
                                <i class="fa fa-list-alt nav-icon"></i>
                                <p>Section</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="jh_enrolled.php" class="nav-link <?php echo $title == 'JH Enrolled Students' ? 'active' : '' ?>">
                                <i class="fa fa-user-check nav-icon"></i>
                                <p>Enrolled Students</p>
                            </a>
                        </li>
                        
                        <li class="nav-item <?php echo 
                            $title == 'JH Enrollees Applicants' 
                            || $title == 'JH Rejected Applicants'  
                            ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?php echo 
                                $title == 'JH Enrollees Applicants' 
                                || $title == 'JH Rejected Applicants'  
                                ? 'active' : '' ?>">
                                <i class="nav-icon fa fa-users"></i>
                                <p> Applicants 
                                    <span class="badge badge-success">
                                        <?php echo get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE 
                                        WHERE status IN ('Scheduled','Pending') AND grade_level BETWEEN 7 AND 10 "); ?>
                                    </span>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="jh_enrollees.php" class="nav-link <?php echo $title == 'JH Enrollees Applicants' ? 'active' : '' ?>">
                                        <i class="fa fa-user-plus nav-icon"></i>
                                        <p>Registrants</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="jh_rejected.php" class="nav-link <?php echo $title == 'JH Rejected Applicants' ? 'active' : '' ?>">
                                        <i class="fa fa-user-times nav-icon"></i>
                                        <p>Rejected</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="archived.php" class="nav-link <?php echo $title == 'Archived' ? 'active' : '' ?>">
                        <i class="fa fa-archive nav-icon"></i>
                        <p>Archived</p>
                    </a>
                </li>

                <?php if ($_SESSION["user_type"] == 'Superadmin') {?>
                <li class="nav-header">SETTINGS</li>
                <li class="nav-item <?php echo $title == 'School Year' || $title == 'Semester'|| $title == 'School Fees' || $title == 'Tuition Plan'  ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?php echo $title == 'School Year' || $title == 'Semester' || $title == 'School Fees' || $title == 'Tuition Plan' ? 'active' : '' ?>">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="school_year.php" class="nav-link <?php echo $title == 'School Year' ? 'active' : '' ?>">
                                <i class="fa fa-calendar-day nav-icon"></i>
                                <p>School Year</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="semester.php" class="nav-link <?php echo $title == 'Semester' ? 'active' : '' ?>">
                                <i class="fa fa-calendar-week nav-icon"></i>
                                <p>Quarter</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="school_fees.php" class="nav-link <?php echo $title == 'School Fees' ? 'active' : '' ?>">
                                <i class="fa fa-table nav-icon"></i>
                                <p>School Fees</p>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="tuition_plan.php" class="nav-link <?php echo $title == 'Tuition Plan' ? 'active' : '' ?>">
                                <i class="fa fa-list-ul nav-icon"></i>
                                <p>Tuition Plan</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="scholarship.php" class="nav-link <?php echo $title == 'Scholarship' ? 'active' : '' ?>">
                                <i class="fa fa-percentage nav-icon"></i>
                                <p>Scholarship</p>
                            </a>
                        </li> -->
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a href="staff_accounts.php" class="nav-link <?php echo $title == 'Staff Accounts' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p> Staff Accounts </p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="reports.php" class="nav-link <?php echo $title == 'Reports' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-print"></i>
                        <p> Reports </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="history.php" class="nav-link <?php echo $title == 'History' ? 'active' : '' ?>">
                        <i class="fa fa-history nav-icon"></i>
                        <p>History</p>
                    </a>
                </li>
                <?php } ?>

                <!-- <li class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p> Logout </p>
                    </a>
                </li> -->
                
            </ul>
        </nav>

    </div>
  </aside>
