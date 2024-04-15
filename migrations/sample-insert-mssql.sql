
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--SET IDENTITY_INSERT "orders" ON ;
INSERT INTO [orders] (id, assign_to, region_id, initiator_id, dept_id, tag_num, item_desc, area_id, priority, status, title, detail_desc, ehs_assest, ehs_hazard, ehs_hazard_risk, replacement, create_at, update_at, complete_at) VALUES
('1112021001', 4, 1, 1, 1, 'AC-001', 'Dehumidifier 14-2', 11, 2, 2, 'TEST akhskahsakhskaksha ashakshkahs aksjkasjkajskajs aksjaksjkajskajsak asjasjkajsakjsksjakjs jshjdhsjhdjshd ksdjksjdksdkjskdjs sdjskdjksjdksjkdj sdjskjdksjdksjd skjdksjdksjkdskjd sdjsljdlsdjsl sdlsdlsjdlj alsjlaslajslajs lajlsjalsjlajs <br> alsjlaslajs a', 'test zzzzzzzzzzz asasa ask;as;aks asalsalsjal askask;aks aska;sk;aska aska;sk;aks aska;ska;asas assas;aks;ka;sk ask;as;ask;a asa;sk;aks;ak laslaslakslaks aska;ks;aks;aks a;sa;ks;aks;aks;ka;ksjjasalslajs asklasklakslaks aslkalslakslask askalsklakslkalsklaks askalsklakslaklsk asaaaaaaaaa', 'N/A', 'N/A', 'N/A', NULL, '2021-11-01 03:04:54', '2021-11-01 03:04:54', '2021-11-02 10:58:07'),
('1112021002', 1, 1, 4, 3, 'WS-33-13310', 'Weight', 66, 2, 1, 'asasasasas', 'asasasdfdf', 'N/A', 'N/A', NULL, NULL, '2021-11-10 23:16:35', '2021-11-10 23:16:35', NULL),
('1112021003', 2, 1, 1, 1, 'AC-016', 'AHU System 3', 45, 2, 1, 'axxxx', 'a', 'N/A', 'N/A', NULL, NULL, '2021-11-12 14:42:17', '2021-11-12 14:42:17', NULL),
('2112021001', 40, 2, 1, 1, 'ENG-INS-ATM302', 'Anak Timbang', 39, 1, 1, 'asasa', 'asas', 'N/A', 'N/A', NULL, NULL, '2021-11-15 23:05:18', '2021-11-15 23:05:18', NULL),
('3112021001', 3, 3, 1, 1, 'AC-017', 'AHU System 5', 45, 2, 1, 'asas', 'asa', 'N/A', 'N/A', NULL, NULL, '2021-11-25 11:21:56', '2021-11-25 11:21:56', NULL),
('3112021002', 7, 3, 1, 1, 'AC-017', 'AHU System 5', 45, 2, 1, 'rusak\r\n', 'asas', 'N/A', 'N/A', NULL, NULL, '2021-11-25 14:44:33', '2021-11-25 14:44:33', NULL);

--SET IDENTITY_INSERT "orders" OFF;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
