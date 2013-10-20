<?php 

// menu header
$lang['menu_dashboard'] = 'Dashboard';
$lang['menu_projects'] = 'Projects';
$lang['menu_tasks'] = 'Tasks';
$lang['menu_members'] = 'Members';
$lang['menu_settings'] = 'Settings';
$lang['menu_my_profile'] = 'Profile';
$lang['menu_logout'] = 'Logout';
$lang['menu_english'] = 'English';
$lang['menu_portuguese'] = 'Portuguese';

// footer infos
$lang['footer_powered_by'] = 'Beta Version - Powered by';

// messages 
// error messages
$lang['msg_error_email_missing'] = "You must submit an email address";
$lang['msg_error_incorrect_email_pass'] = "Oops! E-Mail/Password incorrect.";
$lang['msg_error_incorrect_login_pass'] = "Oops! Login/Password incorrect.";
$lang['msg_error_incorrect_company'] = "Oops! Company incorrect. Try again!";
$lang['msg_error_pass_not_changed'] = "Oops! Error on change your password.";
$lang['msg_error_try_again'] = "Oops! Try again, please.";
$lang['msg_error_email_not_found'] = "Oops! E-Mail not found.";
$lang['msg_error_project_not_found'] = "Oops! Project not found.";
$lang['msg_error_task_not_found'] = "Oops! Task not found.";
$lang['msg_error_no_permission_access'] = "Sorry! You dont have permission to access this.";
$lang['msg_error_no_can_change_admin_master'] = "Oops! Member are the Administrator to your account. You cant do this";
$lang['msg_error_email_exists'] = "Oops! Sorry, e-mail exists. Try again!";
$lang['msg_error_login_exists'] = "Oops! Sorry, login exists. Try again!";
$lang['msg_error_choose_a_project_please'] = "Oops! You need choose a project!";
$lang['msg_error_plan_project_no_more'] = "Oops! Exceed limit of project to your plan!";
$lang['msg_error_company_not_active'] = "Please, active your account!";

// success messages
$lang['msg_ok_email_missing'] = "You must submit an email address";
$lang['msg_ok_pass_changed'] = "Password changed with success!";
$lang['msg_ok_company_activated'] = "Your account was activated!";
$lang['msg_ok_report_sent'] = "Thank you for your help!";

// info messages
$lang['msg_info_email_recover_pass'] = "Yep! See your email!";
$lang['msg_info_sent_email_new_account'] = "Yep! See your email!";

// others messages
$lang['msg_confirm_task_remove'] = 'You wish remove this task?';
$lang['msg_confirm_task_finalize'] = 'You wish finalize this task?';
$lang['msg_confirm_member_remove'] = 'You wish remove this member?';
$lang['msg_notify_by_email'] = 'Notify member by email';
$lang['msg_confirm_project_remove'] = 'You wish remove this project?';

// email messages and infos
$lang['msg_notify_member_new_task_subject'] = '%s New task to you';
$lang['msg_notify_member_new_task_message'] = '
Hey, {member_name}!

See your new task.
Task Name: {task_name} 
Task Priority: {task_priority}
Due date: {task_due_date}

Good work. :)';

$lang['msg_new_company_registered_subject'] = '%s Welcome to Taskino';
$lang['msg_new_company_registered_message'] = '
Hey, {member_name}!

Company name: {company_name}
Please activate your new account.
{url_account_activate}

Good Work. :)';

$lang['company'] = 'Company';
$lang['companies'] = 'Companies';
$lang['no_company'] = 'No Company';
$lang['company_select_option'] = 'Select a Company';
$lang['company_url_logo'] = 'URL Logo';
$lang['company_disk_usage'] = 'Total disk usage';
$lang['plan_max_disk_usage'] = 'Max disk usage on this plan';
$lang['project_max_this_plan'] = 'Projects Max on this plan';

// registration
$lang['reg_company_name'] = 'Company name';
$lang['reg_member_name'] = 'Your name';
$lang['reg_register'] = 'Register';
$lang['reg_accept_terms_policy'] = 'By clicking you agree to the <a href="{url_terms}">Terms of Service</a> and <a href="{url_policy}">Privacy policies</a>.';
//$lang['reg_company_name'] = 'Company';

// plan info
$lang['plan'] = 'Plan';
$lang['plans'] = 'Plans';
$lang['plan_select_option'] = 'Select a plan';
$lang['free'] = 'Free';
$lang['basic'] = 'Basic';

$lang['report_error'] = 'Report a Bug';
$lang['report_title'] = 'Title';
$lang['report_where'] = 'Where?';
$lang['report_where_placeholder'] = 'Where you found it?';
$lang['report_description'] = 'Description';
$lang['report_description_placeholder'] = 'Describe the error, please.';

//
$lang['tasks'] = 'Tasks';
$lang['task'] = 'Task';
$lang['no_tasks'] = 'No Tasks :)';
$lang['task_add_txt'] = 'Add Task';
$lang['task_view'] = 'View Task';

$lang['projects'] = "Projects";
$lang['project'] = "Project";
$lang['no_projects'] = 'No projects.';
$lang['project_add_txt'] = 'Add Project';
$lang['project_view'] = 'View Project';
$lang['recents_comments'] = 'Recent Comments';

$lang['members'] = 'Members';
$lang['member'] = 'Member';
$lang['member_add_txt'] = 'Add member';
$lang['no_members'] = 'No members :(';
$lang['member_select_option'] = 'Select a member';
$lang['language_default'] = 'Linguagem padrão';

$lang['files'] = 'Files';
$lang['file'] = 'File';
$lang['file_add'] = 'Add File';
$lang['no_files'] = 'No files';
$lang['file_download'] = 'Download file';
$lang['file_remove'] = 'Remove file';
$lang['file_choose_file'] = 'Choose a file';
$lang['file_no_file_selected'] = 'No file selected';
$lang['file_description'] = 'Description to file';
$lang['task_upload'] = 'File Upload';

$lang['comments'] = 'Comments';
$lang['comment'] = 'Comment';
$lang['comment_add'] = 'Add Comment';
$lang['no_comments'] = 'Ops! No Comments. :)';

$lang['priority_very_low'] = 'Very Low';
$lang['priority_low'] = 'Low';
$lang['priority_normal'] = 'Normal';
$lang['priority_high'] = 'High';
$lang['priority_very_high'] = 'Very High';

$lang['settings'] = 'Settings';
$lang['plan_can_send_sms'] = 'Can send SMS?';

// title tables and others
$lang['name'] = 'Name';
$lang['email'] = 'E-Mail';
$lang['login'] = 'Login';
$lang['options'] = 'Options';
$lang['password'] = 'Password';
$lang['password_confirm'] = 'Confirm Password ';
$lang['assigned_to'] = 'Assigned to';
$lang['due_date'] = 'Due date';
$lang['created_by'] = 'Created By';
$lang['edit'] = 'Edit';
$lang['remove'] = 'Remove'; 
$lang['change_password'] = 'Change password';
$lang['finalize'] = 'Finalize'; // icon finalize task 
$lang['save'] = 'Save'; // button save 
$lang['reset'] = 'Reset'; // field reset
$lang['see_more'] = 'See more';
$lang['priority'] = 'Priority';
$lang['progress'] = 'Progress';
$lang['description'] = 'Description';
$lang['task_files'] = 'Task files';
$lang['no_description'] = 'No Description';
$lang['subject'] = 'Subject';
$lang['at'] = 'at'; // 'at' to time 
$lang['cancel'] = 'Cancel'; 
$lang['upload'] = 'Upload'; 
$lang['password'] = 'Password';
$lang['forgot_password'] = 'Forgot password';
$lang['back'] = 'back';
$lang['recover'] = 'Recover';
$lang['is_admin'] = 'Is Admin';
$lang['yes'] = 'Yes';
$lang['no'] = 'No';