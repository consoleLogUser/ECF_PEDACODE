-- Jeu d'essais
use pedacode;

INSERT INTO `subscription` (`id_sub`, `name_sub`, `type_sub`) VALUES
(1, 'Standard', 'none'),
(2, 'Premium', 'prime');


INSERT INTO `category` (`id_cat`, `name_cat`) VALUES
(1, 'HTML'),
(2, 'CSS'),
(3, 'JAVASCRIPT');

INSERT INTO `chapter` (`id_ch`, `id_cat`, `title_ch`) VALUES
(1, 1, 'HTML Debutant'),
(2, 2, 'CSS Debutant'),
(3, 3, 'JS Debutant'),
(4, 1, 'HTML Intermediaire'),
(5, 1, 'HTML Avancé'),
(6, 2, 'CSS Intermediaire'),
(7, 2, 'CSS Avancé'),
(8, 3, 'JS Intermediaire'),
(9, 3, 'JS Avancé');

INSERT INTO `lesson` (`id_les`, `title_les`, `instr_les`, `modif_les`, `id_ch`, `id_sub`) VALUES
(1, 'Leçon HTML 1', 'Dans cette leçon Html n°1 nous verrons : Lorem Ipsum ,  Lorem Ipsum, Lorem Ipsum, Lorem Ipsum', '2024-05-19 19:32:08', 1, 1),
(2, 'Leçon CSS 1 ', 'Dans cette leçon CSS n°1 nous verrons : Lorem Ipsum ,  Lorem Ipsum, Lorem Ipsum, Lorem Ipsum', '2024-05-19 19:37:00', 2, 1),
(3, 'Leçon CSS 2', 'Dans cette leçon CSS n°2 nous verrons : Lorem Ipsum ,  Lorem Ipsum, Lorem Ipsum, Lorem Ipsum', '2024-05-19 19:37:27', 2, 2),
(4, 'Leçon HTML 2', 'Dans cette leçon Html n°2 nous verrons : Lorem Ipsum ,  Lorem Ipsum, Lorem Ipsum, Lorem Ipsum', '2024-05-19 19:34:59', 1, 2);


INSERT INTO `goal` (`id_goal`, `descr_goal`, `condi_goal`, `id_les`) VALUES
(1, 'Créer un h1 avec le texte \"Mon H1\"', '{\"Jeton\": \"test\"}', 1),
(2, 'Créer un p avec le texte \"Mon premier paragraphe\"', '{\"Jeton\": \"test\"}', 1),
(3, 'Créer une div englobant le paragraphe', '{\"Jeton\": \"test\"}', 2);


INSERT INTO `langage` (`id_lang`, `name_lang`, `editor_lang`) VALUES
(1, 'HTML', 'html'),
(2, 'CSS', 'css'),
(3, 'JavaScript', 'javascript');


INSERT INTO `userprofile` (`id_user`, `id_sub`, `pwd_user`, `role_user`, `mail_user`, `pseudo_user`, `date_sub`) VALUES
(1, 1, '$2y$10$..V4Q9HsEhuouDQCi0RqmebqnJKYlxH8pI3DU1z6ss7ym18Jh9FZ6', 'admin', 'Aimane@test.com', 'Aimane', NULL);

-- select create_playg_workspace(1, 'Practice html', 0) as id_pg_wk1;
-- select create_playg_workspace(2, 'mon Workspace 1', 0) as id_pg_wk2;
-- select create_playg_workspace(2, 'mon Workspace 2', 1) as id_pg_wk3;

-- select create_repo_less_workspace(1, 1) as id_les_repo_wk1;
-- select create_repo_less_workspace(2, 2) as id_les_repo_wk2;
-- select create_repo_less_workspace(2, 3) as id_les_repo_wk3;

-- INSERT INTO Code (id_wk, id_lang, data_cod) VALUES
--     (1, 1, '<h1>Hello World</h1>'),
--     (2, 1, '<p>Papypuce<p>'),
--     (2, 3, 'console.log(42)'),
--     (3, 1, '<h1>Welcome to my page !</h1>'),
--     (4, 1, '<h2>Welcome to my page !</h2>'),
--     (5, 1, '<h3>Welcome to my page !</h3>'),
--     (6, 1, '<h4>Welcome to my page !</h4>');

-- select create_fork_less_workspace(2, 3, 0) as id_les_fork_wk1;