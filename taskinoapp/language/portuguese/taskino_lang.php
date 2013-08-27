<?php 

// menu header
$lang['menu_dashboard'] = 'Dashboard';
$lang['menu_projects'] = 'Projetos';
$lang['menu_tasks'] = 'Tarefas';
$lang['menu_members'] = 'Usuários';
$lang['menu_settings'] = 'Configurações';
$lang['menu_my_profile'] = 'Perfil';
$lang['menu_logout'] = 'Sair';
$lang['menu_english'] = 'Inglês';
$lang['menu_portuguese'] = 'Português';

// footer infos
$lang['footer_powered_by'] = 'Versão Beta - Desenvolvido por';

// messages 
// error messages
$lang['msg_error_email_missing'] = "You must submit an email address";
$lang['msg_error_incorrect_email_pass'] = "Oops! E-mail/Senha incorreto(s)";
$lang['msg_error_incorrect_login_pass'] = "Oops! Login/Senha incorreto(s).";
$lang['msg_error_incorrect_company'] = "Oops! Empresa incorreta. Tenve novamente!";
$lang['msg_error_pass_not_changed'] = "Oops! Erro ao alterar senha.";
$lang['msg_error_try_again'] = "Oops! Por favor, tente novamente.";
$lang['msg_error_email_not_found'] = "Oops! E-Mail não encontrado.";
$lang['msg_error_project_not_found'] = "Oops! Projeto não encontrado.";
$lang['msg_error_task_not_found'] = "Oops! Tarefa não encontrada.";
$lang['msg_error_no_permission_access'] = "Desculpa! Você não tem permissão para acessar esse conteúdo.";
$lang['msg_error_no_can_change_admin_master'] = "Oops! Usuario é o Administrador de Conta. Não pode fazer isso.";
$lang['msg_error_email_exists'] = "Oops! E-mail já cadastrado. Tente novamente!";
$lang['msg_error_login_exists'] = "Oops! Login já cadastrado. Tente novamente!";
$lang['msg_error_choose_a_project_please'] = "Oops! Você precisa escolher um projeto!";
$lang['msg_error_plan_project_no_more'] = "Oops! Máximo de projetos permitidos para esse plano!";
$lang['msg_error_company_not_active'] = "Por favor, ative sua conta!";

// success messages
$lang['msg_ok_email_missing'] = "You must submit an email address";
$lang['msg_ok_pass_changed'] = "Senha alterada com sucesso!";
$lang['msg_ok_company_activated'] = "Sua conta foi ativada!";
$lang['msg_ok_report_sent'] = "Obrigado por sua ajuda!";

// info messages
$lang['msg_info_email_recover_pass'] = "Ueba! Verifique seu email!";
$lang['msg_info_sent_email_new_account'] = "Ueba! Verifique seu email!";

// others messages
$lang['msg_confirm_task_remove'] = 'Tem certeza que deseja remover a tarefa e itens associados a ela?';
$lang['msg_confirm_task_finalize'] = 'Tem certeza que deseja finalizar a tarefa?';
$lang['msg_confirm_member_remove'] = 'Deseja remover este usuário?';
$lang['msg_notify_by_email'] = 'Notificar usuário por email';
$lang['msg_confirm_project_remove'] = 'Tem certeza que deseja remover o projeto e itens relacionados?';

// email messages and infos
$lang['msg_notify_member_new_task_subject'] = '%s Nova tarefa';
$lang['msg_notify_member_new_task_message'] = '
Olá, {member_name}!

Você tem nova tarefa.
Nome da tarefa: {task_name} 
Prioridade: {task_priority}
Prazo: {task_due_date}

Bom trabalho. :)';

$lang['msg_new_company_registered_subject'] = '%s Seja bem vindo';
$lang['msg_new_company_registered_message'] = '
Olá, {member_name}!

Nome da empresa: {company_name}
Por favor, ative sua nova conta.
{url_account_activate}

Bom trabalho. :)';

$lang['company'] = 'Empresa';
$lang['companies'] = 'Empresas';
$lang['no_company'] = 'Sem empresas';
$lang['company_select_option'] = 'Selecione uma empresa';
$lang['company_url_logo'] = 'URL da Logo';
$lang['company_disk_usage'] = 'Espaço usado';
$lang['plan_max_disk_usage'] = 'Máx. de espaço nesse plano';
$lang['project_max_this_plan'] = 'Máx. de projetos nesse plano';

// registration
$lang['reg_company_name'] = 'Nome da empresa';
$lang['reg_member_name'] = 'Seu nome';
$lang['reg_register'] = 'Cadastrar';
$lang['reg_accept_terms_policy'] = 'Ao se cadastrar você concorda com nossos <a href="{url_terms}">Termos de Serviço</a> e <a href="{url_policy}">Politicas de Privacidade</a>.';
//$lang['reg_company_name'] = 'Company';

// plan info
$lang['plan'] = 'Plano';
$lang['plans'] = 'Planos';
$lang['plan_select_option'] = 'Selecione um plano';
$lang['free'] = 'Grátis';
$lang['basic'] = 'Básico';

$lang['report_error'] = 'Informar um erro';
$lang['report_title'] = 'Titulo';
$lang['report_where'] = 'Onde?';
$lang['report_where_placeholder'] = 'Onde achou o erro?';
$lang['report_description'] = 'Descrição';
$lang['report_description_placeholder'] = 'Por favor, descreva o error detalhadamente.';

//
$lang['tasks'] = 'Tarefas';
$lang['task'] = 'Tarefa';
$lang['no_tasks'] = 'Sem tarefas :)';
$lang['task_add_txt'] = 'Adicionar tarefa';
$lang['task_view'] = 'Ver tarefa';

$lang['projects'] = "Projetos";
$lang['project'] = "Projeto";
$lang['no_projects'] = 'Sem projetos.';
$lang['project_add_txt'] = 'Adicionar Projeto';
$lang['project_view'] = 'Ver Projeto';
$lang['recents_comments'] = 'Últimos Comentários';

$lang['members'] = 'Usuários';
$lang['member'] = 'Usuário';
$lang['member_add_txt'] = 'Adicionar usuário';
$lang['no_members'] = 'Nenhum usuário :(';
$lang['member_select_option'] = 'Selecione usuário';
$lang['language_default'] = 'Linguagem padrão';

$lang['files'] = 'Arquivos';
$lang['file'] = 'Arquivo';
$lang['file_add'] = 'Adicionar arquivo';
$lang['no_files'] = 'Nenhum arquivo adicionado';
$lang['file_download'] = 'Baixar arquivo';
$lang['file_remove'] = 'Remover arquivo';
$lang['file_choose_file'] = 'Escolha um arquivo';
$lang['file_no_file_selected'] = 'Nenhum arquivo escolhido';
$lang['file_description'] = 'Descrição para arquivo';
$lang['task_upload'] = 'Upload de arquivo';

$lang['comments'] = 'Comentários';
$lang['comment'] = 'Comentário';
$lang['comment_add'] = 'Adicionar Comentário';
$lang['no_comments'] = 'Oops! Sem Comentários. :)';

$lang['priority_very_low'] = 'Muito baixa';
$lang['priority_low'] = 'Baixa';
$lang['priority_normal'] = 'Normal';
$lang['priority_high'] = 'Alta';
$lang['priority_very_high'] = 'Muito Alta';

$lang['settings'] = 'Configurações';


// title tables
$lang['name'] = 'Nome';
$lang['email'] = 'E-Mail';
$lang['login'] = 'Login';
$lang['options'] = 'Opções';
$lang['password'] = 'Senha';
$lang['password_confirm'] = 'Confirmar Senha ';
$lang['assigned_to'] = 'Atribuido para'; // mandar para
$lang['due_date'] = 'Prazo';
$lang['created_by'] = 'Criado por';
$lang['edit'] = 'Editar';
$lang['remove'] = 'Remover'; 
$lang['change_password'] = 'Mudar senha';
$lang['finalize'] = 'Finalizar'; // icon finalize task 
$lang['save'] = 'Salvar'; // button save 
$lang['reset'] = 'Redefinir'; // field reset
$lang['see_more'] = 'Veja mais';
$lang['priority'] = 'Prioridade';
$lang['progress'] = 'Progresso';
$lang['description'] = 'Descrição';
$lang['task_files'] = 'Arquivos';
$lang['no_description'] = 'Sem descrição';
$lang['subject'] = 'Assunto';
$lang['at'] = 'as'; // 'at' to time 
$lang['cancel'] = 'Cancelar'; 
$lang['upload'] = 'Upload'; 
$lang['password'] = 'Senha';
$lang['forgot_password'] = 'Esqueci a senha';
$lang['back'] = 'voltar';
$lang['recover'] = 'Recuperar';
$lang['is_admin'] = 'É Administrador';
$lang['yes'] = 'Sim';
$lang['no'] = 'Não';