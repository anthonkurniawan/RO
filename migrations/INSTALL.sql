--:on error exit  -- only works on sqlcmd
SET ANSI_NULLS ON
GO

--SET QUOTED_IDENTIFIER ON
--GO
SET nocount ON  -- DONT PRINT RESULT eg: (1 rows affected)
GO

-- sqlcmd -U sa -P belang -Q "drop table dept,area,comment,users,region,tag,ehs_ass,priority,orders,log"
-- sqlcmd -U sa -P belang -Q "select name from sys.tables"

--DECLARE @HAS_ERROR BIT
if object_id('tempdb..#test') is not null
begin
  drop table #test
end

create table #test (hasError bit)
insert #test values (0)

IF EXISTS(SELECT name FROM sys.databases where name='RO')
DROP DATABASE RO
GO

PRINT 'CREATE DATABASE RO'
CREATE DATABASE RO
GO
USE RO
GO

BEGIN transaction;
IF (@@ERROR = 0) BEGIN
PRINT 'Start Copy..'

PRINT 'CREATE TABLE "users"'
CREATE TABLE [dbo].[users](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[username] [nvarchar](255) NOT NULL,
	[fullname] [nvarchar](255) NULL,
	[email] [nvarchar](255) NULL,
	[dept_id] [int] NOT NULL,
	[status] [smallint] NOT NULL DEFAULT ((1)),
	[role] [int] NOT NULL DEFAULT ((3)),
	[spv] [nvarchar](255) NULL,
	[signature] [nvarchar](50) NULL,
	[priv] [nvarchar](255) NULL,
	[created_at] [int] NOT NULL,
	[updated_at] [int] NULL,
	[last_loged] [int] NULL,
	[auth_key] [nvarchar](50) NULL,
	[password_hash] [nvarchar](255) NULL,
	[access_token] [nvarchar](255) NULL,
	[password_reset_token] [nvarchar](255) NULL,
 CONSTRAINT [PK_users_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO

--print @@ERROR
IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT 'CREATE TABLE "dept"'
CREATE TABLE [dbo].[dept](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[code] [nvarchar](50) NULL,
	[label] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_dept_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT 'CREATE TABLE "area"'
CREATE TABLE [dbo].[area](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[label_a] [nvarchar](255) NOT NULL,
 CONSTRAINT [PK_area_id] PRIMARY KEY CLUSTERED
(
[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT 'CREATE TABLE "tag"'
CREATE TABLE [dbo].[tag](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[area_id] [int] NULL,
	[tagnum] [nvarchar](150) NOT NULL,
	[desct] [nvarchar](255) NOT NULL,
 CONSTRAINT [PK_tag_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT 'CREATE TABLE "region"'
CREATE TABLE [dbo].[region](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[dept_id] [int] NOT NULL DEFAULT ((1)),
	[nama] [nvarchar](100) NOT NULL,
 CONSTRAINT [PK_region_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT 'CREATE TABLE "ehs_ass"'
CREATE TABLE [ehs_ass]([id] [int] IDENTITY(1,1) NOT NULL,[label] [nvarchar](100) NOT NULL, PRIMARY KEY (id))
END
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT 'CREATE TABLE "priority"'
CREATE TABLE [priority]([id] [int] IDENTITY(1,1) NOT NULL, [label] [nvarchar](100) NOT NULL, PRIMARY KEY (id))
END
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT 'CREATE TABLE "orders"'
CREATE TABLE [dbo].[orders](
	[id] [nvarchar](12) NOT NULL,
	[assign_to] [int] NOT NULL,
	[region_id] [int] NOT NULL,
	[initiator_id] [int] NOT NULL,
	[dept_id] [int] NOT NULL,
	[tag_num] [nvarchar](100) NOT NULL,
	[item_desc] [nvarchar](255) NOT NULL,
	[area] [nvarchar](255) NOT NULL,
	[priority] [smallint] NOT NULL,
	[status] [smallint] NOT NULL,
	[title] [nvarchar](255) NOT NULL,
	[detail_desc] [nvarchar](max) NULL,
	[ehs_assest] [nvarchar](255) NULL,
	[ehs_hazard] [nvarchar](20) NULL,
	[ehs_hazard_risk] [nvarchar](max) NULL,
	[replacement] [nvarchar](max) NULL,
	[create_at] [smalldatetime] NOT NULL,
	[update_at] [smalldatetime] NOT NULL,
	[complete_at] [smalldatetime] NULL,
 CONSTRAINT [PK_orders_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT 'CREATE TABLE "comment"'
CREATE TABLE [dbo].[comment](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NOT NULL,
	[order_id] [nvarchar](12) NOT NULL,
	[comment] [nvarchar](max) NULL,
	[time] [int] NOT NULL,
 CONSTRAINT [PK_comment_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT 'CREATE TABLE "log"'
CREATE TABLE [dbo].[log](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[date] [smalldatetime] NOT NULL,
	[userid] [int] NULL,
	[event] [nvarchar](255) NOT NULL,
 CONSTRAINT [PK_log_id] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END
GO

SET nocount OFF
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT ''
PRINT 'START COPY DATA..'
PRINT 'INSERT INTO TABLE "users"'
SET IDENTITY_INSERT [dbo].[users] ON
INSERT [dbo].[users] ([id], [uname], [fullname], [email], [dept_id], [status], [role], [spv], [signature], [priv], [created_at], [updated_at], [last_loged], [auth_key], [password_hash], [access_token], [password_reset_token]) 
VALUES (1, N'admin', N'Super Admin', N'anthon.awan@gmail.com', 1, 1, 1, NULL, NULL, N'', 1625132687, 1637316909, 1638246174, N'G1jP3uQH7WaiQLPncAzTRgyrI23E5WPF',N'$2y$13$eX8tJOIm19riFdGz2/hVnux0Tku.QbfsGyD78yvewCr2XDUrNXKgW',N'LPjSE2bZRLsY_SH58YPXyFf3nsvZsvQD_admin',NULL)
SET IDENTITY_INSERT [dbo].[users] OFF
END
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT ''
PRINT 'INSERT INTO TABLE "dept"'
SET IDENTITY_INSERT [dbo].[dept] ON
INSERT [dbo].[dept] ([id], [code], [label]) VALUES (1, N'eng', N'Engineering')
INSERT [dbo].[dept] ([id], [code], [label]) VALUES (2, N'prod', N'Production')
INSERT [dbo].[dept] ([id], [code], [label]) VALUES (3, N'wh', N'Warehouse')
INSERT [dbo].[dept] ([id], [code], [label]) VALUES (4, N'qo', N'Quality Operation')
INSERT [dbo].[dept] ([id], [code], [label]) VALUES (5, N'qa', N'Quality Assurance')
SET IDENTITY_INSERT [dbo].[dept] OFF
END
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT ''
PRINT 'INSERT INTO TABLE "region"'
SET IDENTITY_INSERT [dbo].[region] ON
INSERT [dbo].[region] ([id], [dept_id], [nama]) VALUES (1, 1, N'Maintenace')
INSERT [dbo].[region] ([id], [dept_id], [nama]) VALUES (2, 1, N'Utility')
INSERT [dbo].[region] ([id], [dept_id], [nama]) VALUES (3, 1, N'Calibration')
INSERT [dbo].[region] ([id], [dept_id], [nama]) VALUES (4, 1, N'Automation')
INSERT [dbo].[region] ([id], [dept_id], [nama]) VALUES (5, 1, N'Facility')
INSERT [dbo].[region] ([id], [dept_id], [nama]) VALUES (6, 1, N'EHS')
INSERT [dbo].[region] ([id], [dept_id], [nama]) VALUES (7, 1, N'Other')
SET IDENTITY_INSERT [dbo].[region] OFF
END
GO


IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT ''
PRINT 'INSERT INTO TABLE "priority"'
SET IDENTITY_INSERT [priority] ON
INSERT INTO [priority] (id, label) VALUES (1, 'Breakdown')
INSERT INTO [priority] (id, label) VALUES (2, 'Pro Aktif Maintenance')
INSERT INTO [priority] (id, label) VALUES (3, 'TPM')
INSERT INTO [priority] (id, label) VALUES (4, 'Other')
SET IDENTITY_INSERT [priority] OFF
END
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT ''
PRINT 'INSERT INTO TABLE "ehs_ass"'
SET IDENTITY_INSERT [ehs_ass] ON ;
INSERT INTO [ehs_ass] (id, label) VALUES (1, 'None')
INSERT INTO [ehs_ass] (id, label) VALUES (2, 'Ergonomic / Manual Handling')
INSERT INTO [ehs_ass] (id, label) VALUES (3, 'Penyimpanan & Material Safety')
INSERT INTO [ehs_ass] (id, label) VALUES (4, 'High Hazard Work')
INSERT INTO [ehs_ass] (id, label) VALUES (5, 'Working Equipment')
INSERT INTO [ehs_ass] (id, label) VALUES (6, 'Kesehatan')
INSERT INTO [ehs_ass] (id, label) VALUES (7, 'Occupational Hygiene')
INSERT INTO [ehs_ass] (id, label) VALUES (8, 'Environmental')
INSERT INTO [ehs_ass] (id, label) VALUES (9, 'Safe Workplace')
INSERT INTO [ehs_ass] (id, label) VALUES (10, 'Bahaya Listrik')
INSERT INTO [ehs_ass] (id, label) VALUES (11, 'APD dan Penandaan')
INSERT INTO [ehs_ass] (id, label) VALUES (12, 'Fire and Life Safety')
INSERT INTO [ehs_ass] (id, label) VALUES (13, 'Other')
SET IDENTITY_INSERT [ehs_ass] OFF ;
END
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT ''
PRINT 'INSERT INTO TABLE "area"'
SET IDENTITY_INSERT [dbo].[area] ON
INSERT [dbo].[area] ([id], [label_a]) VALUES (1, N'AHU 03')
INSERT [dbo].[area] ([id], [label_a]) VALUES (2, N'AHU 09')
INSERT [dbo].[area] ([id], [label_a]) VALUES (3, N'AHU 14')
INSERT [dbo].[area] ([id], [label_a]) VALUES (4, N'AHU 14A')
INSERT [dbo].[area] ([id], [label_a]) VALUES (5, N'AHU 14B')
INSERT [dbo].[area] ([id], [label_a]) VALUES (6, N'AHU 15')
INSERT [dbo].[area] ([id], [label_a]) VALUES (7, N'AHU 16')
INSERT [dbo].[area] ([id], [label_a]) VALUES (8, N'AHU 17')
INSERT [dbo].[area] ([id], [label_a]) VALUES (9, N'AHU 18')
INSERT [dbo].[area] ([id], [label_a]) VALUES (10, N'AHU 20')
INSERT [dbo].[area] ([id], [label_a]) VALUES (11, N'AHU 21')
INSERT [dbo].[area] ([id], [label_a]) VALUES (12, N'AHU 24.1')
INSERT [dbo].[area] ([id], [label_a]) VALUES (13, N'AHU 24.2')
INSERT [dbo].[area] ([id], [label_a]) VALUES (14, N'AHU 25')
INSERT [dbo].[area] ([id], [label_a]) VALUES (15, N'AHU 26')
INSERT [dbo].[area] ([id], [label_a]) VALUES (16, N'AHU 27')
INSERT [dbo].[area] ([id], [label_a]) VALUES (17, N'AHU 28')
INSERT [dbo].[area] ([id], [label_a]) VALUES (18, N'AHU 304')
INSERT [dbo].[area] ([id], [label_a]) VALUES (19, N'AHU 305')
INSERT [dbo].[area] ([id], [label_a]) VALUES (20, N'AHU 9')
INSERT [dbo].[area] ([id], [label_a]) VALUES (21, N'AHU 9.2')
INSERT [dbo].[area] ([id], [label_a]) VALUES (22, N'AHU 9.3&9.4')
INSERT [dbo].[area] ([id], [label_a]) VALUES (23, N'AHU 9.4')
INSERT [dbo].[area] ([id], [label_a]) VALUES (24, N'Airlock')
INSERT [dbo].[area] ([id], [label_a]) VALUES (25, N'Biologycal Safety Cabinet')
INSERT [dbo].[area] ([id], [label_a]) VALUES (26, N'Cimanggis')
INSERT [dbo].[area] ([id], [label_a]) VALUES (27, N'Coldbox GD05')
INSERT [dbo].[area] ([id], [label_a]) VALUES (28, N'Combantrin Area')
INSERT [dbo].[area] ([id], [label_a]) VALUES (29, N'Cooling Stg')
INSERT [dbo].[area] ([id], [label_a]) VALUES (30, N'Corridor')
INSERT [dbo].[area] ([id], [label_a]) VALUES (31, N'Female Access Area')
INSERT [dbo].[area] ([id], [label_a]) VALUES (32, N'Filtration')
INSERT [dbo].[area] ([id], [label_a]) VALUES (33, N'Generator')
INSERT [dbo].[area] ([id], [label_a]) VALUES (34, N'Gowning')
INSERT [dbo].[area] ([id], [label_a]) VALUES (35, N'Isolator')
INSERT [dbo].[area] ([id], [label_a]) VALUES (36, N'Janitor Storage')
INSERT [dbo].[area] ([id], [label_a]) VALUES (37, N'Kalibrasi')
INSERT [dbo].[area] ([id], [label_a]) VALUES (38, N'Kontainer')
INSERT [dbo].[area] ([id], [label_a]) VALUES (39, N'Lab. Kalibrasi')
INSERT [dbo].[area] ([id], [label_a]) VALUES (40, N'LAF EQU 4')
INSERT [dbo].[area] ([id], [label_a]) VALUES (41, N'Laundry')
INSERT [dbo].[area] ([id], [label_a]) VALUES (42, N'Lytzen')
INSERT [dbo].[area] ([id], [label_a]) VALUES (43, N'Male Access Area')
INSERT [dbo].[area] ([id], [label_a]) VALUES (44, N'Mezanine')
INSERT [dbo].[area] ([id], [label_a]) VALUES (45, N'Mezzanine')
INSERT [dbo].[area] ([id], [label_a]) VALUES (46, N'Micro Lab.')
INSERT [dbo].[area] ([id], [label_a]) VALUES (47, N'Mobile')
INSERT [dbo].[area] ([id], [label_a]) VALUES (48, N'Ointment')
INSERT [dbo].[area] ([id], [label_a]) VALUES (49, N'Other Coump')
INSERT [dbo].[area] ([id], [label_a]) VALUES (50, N'Other Liq Fill')
INSERT [dbo].[area] ([id], [label_a]) VALUES (51, N'Outside')
INSERT [dbo].[area] ([id], [label_a]) VALUES (53, N'Packaging')
INSERT [dbo].[area] ([id], [label_a]) VALUES (54, N'Process Oint')
INSERT [dbo].[area] ([id], [label_a]) VALUES (55, N'Production')
INSERT [dbo].[area] ([id], [label_a]) VALUES (56, N'R-102')
INSERT [dbo].[area] ([id], [label_a]) VALUES (57, N'R-103')
INSERT [dbo].[area] ([id], [label_a]) VALUES (58, N'R-108')
INSERT [dbo].[area] ([id], [label_a]) VALUES (59, N'R-109')
INSERT [dbo].[area] ([id], [label_a]) VALUES (60, N'R-110')
INSERT [dbo].[area] ([id], [label_a]) VALUES (61, N'R-1100')
INSERT [dbo].[area] ([id], [label_a]) VALUES (62, N'R-112')
INSERT [dbo].[area] ([id], [label_a]) VALUES (63, N'R-114')
INSERT [dbo].[area] ([id], [label_a]) VALUES (64, N'R-1200')
INSERT [dbo].[area] ([id], [label_a]) VALUES (65, N'R-123')
INSERT [dbo].[area] ([id], [label_a]) VALUES (66, N'R-1300')
INSERT [dbo].[area] ([id], [label_a]) VALUES (67, N'R-133')
INSERT [dbo].[area] ([id], [label_a]) VALUES (68, N'R-134')
INSERT [dbo].[area] ([id], [label_a]) VALUES (69, N'R-135')
INSERT [dbo].[area] ([id], [label_a]) VALUES (70, N'R-135 A')
INSERT [dbo].[area] ([id], [label_a]) VALUES (71, N'R-135A')
INSERT [dbo].[area] ([id], [label_a]) VALUES (72, N'R-136')
INSERT [dbo].[area] ([id], [label_a]) VALUES (73, N'R-137')
INSERT [dbo].[area] ([id], [label_a]) VALUES (74, N'R-139')
INSERT [dbo].[area] ([id], [label_a]) VALUES (75, N'R-140')
INSERT [dbo].[area] ([id], [label_a]) VALUES (76, N'R-1400')
INSERT [dbo].[area] ([id], [label_a]) VALUES (77, N'R-141')
INSERT [dbo].[area] ([id], [label_a]) VALUES (78, N'R-142')
INSERT [dbo].[area] ([id], [label_a]) VALUES (79, N'R-143')
INSERT [dbo].[area] ([id], [label_a]) VALUES (80, N'R-144A')
INSERT [dbo].[area] ([id], [label_a]) VALUES (81, N'R-144B')
INSERT [dbo].[area] ([id], [label_a]) VALUES (82, N'R-145')
INSERT [dbo].[area] ([id], [label_a]) VALUES (83, N'R-1500')
INSERT [dbo].[area] ([id], [label_a]) VALUES (84, N'R-151')
INSERT [dbo].[area] ([id], [label_a]) VALUES (85, N'R-152')
INSERT [dbo].[area] ([id], [label_a]) VALUES (86, N'R-153')
INSERT [dbo].[area] ([id], [label_a]) VALUES (87, N'R-154')
INSERT [dbo].[area] ([id], [label_a]) VALUES (88, N'R-155')
INSERT [dbo].[area] ([id], [label_a]) VALUES (89, N'R-156')
INSERT [dbo].[area] ([id], [label_a]) VALUES (90, N'R-157')
INSERT [dbo].[area] ([id], [label_a]) VALUES (91, N'R-158')
INSERT [dbo].[area] ([id], [label_a]) VALUES (92, N'R-160')
INSERT [dbo].[area] ([id], [label_a]) VALUES (93, N'R-1600')
INSERT [dbo].[area] ([id], [label_a]) VALUES (94, N'R-162')
INSERT [dbo].[area] ([id], [label_a]) VALUES (95, N'R-163')
INSERT [dbo].[area] ([id], [label_a]) VALUES (96, N'R-164')
INSERT [dbo].[area] ([id], [label_a]) VALUES (97, N'R-165')
INSERT [dbo].[area] ([id], [label_a]) VALUES (98, N'R-166')
INSERT [dbo].[area] ([id], [label_a]) VALUES (99, N'R-167')
INSERT [dbo].[area] ([id], [label_a]) VALUES (100, N'R-168')
INSERT [dbo].[area] ([id], [label_a]) VALUES (101, N'R-1700')
INSERT [dbo].[area] ([id], [label_a]) VALUES (102, N'R-182')
INSERT [dbo].[area] ([id], [label_a]) VALUES (103, N'R-183')
INSERT [dbo].[area] ([id], [label_a]) VALUES (104, N'R-185')
INSERT [dbo].[area] ([id], [label_a]) VALUES (105, N'R-190')
INSERT [dbo].[area] ([id], [label_a]) VALUES (106, N'R-191')
INSERT [dbo].[area] ([id], [label_a]) VALUES (107, N'R-192')
INSERT [dbo].[area] ([id], [label_a]) VALUES (108, N'R-193')
INSERT [dbo].[area] ([id], [label_a]) VALUES (109, N'R-203')
INSERT [dbo].[area] ([id], [label_a]) VALUES (110, N'R-204')
INSERT [dbo].[area] ([id], [label_a]) VALUES (111, N'R-209')
INSERT [dbo].[area] ([id], [label_a]) VALUES (112, N'R-210')
INSERT [dbo].[area] ([id], [label_a]) VALUES (113, N'R-212')
INSERT [dbo].[area] ([id], [label_a]) VALUES (114, N'R-213')
INSERT [dbo].[area] ([id], [label_a]) VALUES (115, N'R-217')
INSERT [dbo].[area] ([id], [label_a]) VALUES (116, N'R-251')
INSERT [dbo].[area] ([id], [label_a]) VALUES (117, N'R-253')
INSERT [dbo].[area] ([id], [label_a]) VALUES (118, N'R-256')
INSERT [dbo].[area] ([id], [label_a]) VALUES (119, N'R-257')
INSERT [dbo].[area] ([id], [label_a]) VALUES (120, N'R-258')
INSERT [dbo].[area] ([id], [label_a]) VALUES (121, N'R-259')
INSERT [dbo].[area] ([id], [label_a]) VALUES (122, N'R-301')
INSERT [dbo].[area] ([id], [label_a]) VALUES (123, N'R-302')
INSERT [dbo].[area] ([id], [label_a]) VALUES (124, N'R-304')
INSERT [dbo].[area] ([id], [label_a]) VALUES (125, N'R-305')
INSERT [dbo].[area] ([id], [label_a]) VALUES (126, N'R-306')
INSERT [dbo].[area] ([id], [label_a]) VALUES (127, N'R-307')
INSERT [dbo].[area] ([id], [label_a]) VALUES (128, N'R-308')
INSERT [dbo].[area] ([id], [label_a]) VALUES (129, N'R-309')
INSERT [dbo].[area] ([id], [label_a]) VALUES (130, N'R-310')
INSERT [dbo].[area] ([id], [label_a]) VALUES (131, N'R-311')
INSERT [dbo].[area] ([id], [label_a]) VALUES (132, N'R-312')
INSERT [dbo].[area] ([id], [label_a]) VALUES (133, N'R-313')
INSERT [dbo].[area] ([id], [label_a]) VALUES (134, N'R-314')
INSERT [dbo].[area] ([id], [label_a]) VALUES (135, N'R-316')
INSERT [dbo].[area] ([id], [label_a]) VALUES (136, N'R-317')
INSERT [dbo].[area] ([id], [label_a]) VALUES (137, N'R-318')
INSERT [dbo].[area] ([id], [label_a]) VALUES (138, N'R-319')
INSERT [dbo].[area] ([id], [label_a]) VALUES (139, N'R-321')
INSERT [dbo].[area] ([id], [label_a]) VALUES (140, N'R-323')
INSERT [dbo].[area] ([id], [label_a]) VALUES (141, N'R-324')
INSERT [dbo].[area] ([id], [label_a]) VALUES (142, N'R-328')
INSERT [dbo].[area] ([id], [label_a]) VALUES (143, N'R-332')
INSERT [dbo].[area] ([id], [label_a]) VALUES (144, N'R-334')
INSERT [dbo].[area] ([id], [label_a]) VALUES (145, N'R-5100')
INSERT [dbo].[area] ([id], [label_a]) VALUES (146, N'R-5200')
INSERT [dbo].[area] ([id], [label_a]) VALUES (147, N'R-5300')
INSERT [dbo].[area] ([id], [label_a]) VALUES (148, N'R-5400')
INSERT [dbo].[area] ([id], [label_a]) VALUES (149, N'R-5Q001')
INSERT [dbo].[area] ([id], [label_a]) VALUES (150, N'R-5Q002')
INSERT [dbo].[area] ([id], [label_a]) VALUES (151, N'R-Genset')
INSERT [dbo].[area] ([id], [label_a]) VALUES (152, N'R-Stability')
INSERT [dbo].[area] ([id], [label_a]) VALUES (153, N'Raw Goods Warehouse')
INSERT [dbo].[area] ([id], [label_a]) VALUES (154, N'Sampling booth')
INSERT [dbo].[area] ([id], [label_a]) VALUES (155, N'Storage Cold Box')
INSERT [dbo].[area] ([id], [label_a]) VALUES (156, N'Storage Coldbox')
INSERT [dbo].[area] ([id], [label_a]) VALUES (157, N'Truck Box')
INSERT [dbo].[area] ([id], [label_a]) VALUES (158, N'Uniform')
INSERT [dbo].[area] ([id], [label_a]) VALUES (159, N'Utilities Area')
INSERT [dbo].[area] ([id], [label_a]) VALUES (160, N'Utility')
INSERT [dbo].[area] ([id], [label_a]) VALUES (161, N'Utility Area')
INSERT [dbo].[area] ([id], [label_a]) VALUES (162, N'Utility Control Room')
INSERT [dbo].[area] ([id], [label_a]) VALUES (163, N'UV')
INSERT [dbo].[area] ([id], [label_a]) VALUES (164, N'Visine Coump')
INSERT [dbo].[area] ([id], [label_a]) VALUES (165, N'Visine Liq')
INSERT [dbo].[area] ([id], [label_a]) VALUES (166, N'Ware house')
INSERT [dbo].[area] ([id], [label_a]) VALUES (167, N'Warehouse')
INSERT [dbo].[area] ([id], [label_a]) VALUES (168, N'Washing Str');
SET IDENTITY_INSERT [dbo].[area] OFF
END
GO

IF (@@ERROR != 0)
  update #test set hasError=1
ELSE
BEGIN
PRINT ''
PRINT 'INSERT INTO TABLE "tag"'
SET IDENTITY_INSERT [dbo].[tag] ON
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (1, 84, N'BR-21-15101', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (2, 84, N'BR-21-15102', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (3, 87, N'BR-21-15401', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (4, 137, N'BR-21-15501', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (5, 97, N'BR-21-15502', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (6, 140, N'BR-21-15503', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (7, 86, N'BR-21-16501', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (8, 88, N'BR-21-16502', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (9, 86, N'BR-21-31601', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (10, 60, N'BR-22-11001', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (11, 60, N'BR-22-11002', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (12, 60, N'BR-22-11005', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (13, 60, N'BR-22-11006', N'Check Weigher')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (14, 60, N'BR-22-11008', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (15, 60, N'BR-22-11010', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (16, 60, N'BR-22-11011', N'Balance Readout')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (17, 60, N'BR-22-11012', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (18, 60, N'BR-22-11013', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (19, 60, N'BR-22-11014', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (20, 60, N'BR-22-11015', N'Check Weigher')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (21, 60, N'BR-22-11016', N'Balance')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (22, 79, N'BR-25-14302', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (23, 66, N'BR-32-11201', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (24, 60, N'BR-33-10302', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (25, 57, N'BR-33-10306', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (26, 139, N'BR-33-10307', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (27, 67, N'BR-33-10308', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (28, 67, N'BR-33-32802', N'Balance Readout')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (29, 142, N'BR-33-32803', N'Balance Readout')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (30, 135, N'BR-33-32804', N'Balance Readout')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (31, 142, N'BR-33-32805', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (32, 67, N'BR-93-00101-A', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (33, 67, N'BR-93-00101-B', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (34, 60, N'BR-93-00101-C', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (35, 99, N'BR-93-02101', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (36, 92, N'BR-93-02102', N'Balance Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (37, 69, N'CIT-11-13503-CB', N'Conductivity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (38, 69, N'CIT-11-13506-CB', N'Conductivity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (39, 69, N'CIT-11-13507-CB', N'Conductivity Meter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (40, 69, N'CIT-11-13508-CB', N'Conductivity Meter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (41, 69, N'CIT-11-13509-CB', N'Conductivity Meter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (42, 72, N'CIT-11-13605-CB', N'Conductivity Meter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (43, 72, N'CIT-11-13606-CB', N'Conductivity Meter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (44, 72, N'CIT-11-13607-CB', N'Conductivity Meter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (45, 72, N'CIT-11-13608-CB', N'Conductivity Meter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (46, 126, N'CIT-11-30602', N'Conductivity Meter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (47, 126, N'CIT-19-30601', N'Conductivity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (48, 44, N'DPI-19-33201', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (49, 84, N'DPI-21-15101', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (50, 85, N'DPI-21-15203', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (51, 87, N'DPI-21-15403', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (52, 88, N'DPI-21-15501', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (53, 89, N'DPI-21-15603', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (54, 90, N'DPI-21-15703', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (55, 91, N'DPI-21-15803', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (56, 92, N'DPI-21-16001', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (57, 92, N'DPI-21-16002', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (58, 94, N'DPI-21-16204', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (59, 95, N'DPI-21-16303', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (60, 96, N'DPI-21-16403', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (61, 97, N'DPI-21-16501', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (62, 98, N'DPI-21-16603', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (63, 99, N'DPI-21-16703', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (64, 100, N'DPI-21-16803', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (65, 122, N'DPI-21-30104', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (66, 122, N'DPI-21-30105', N'Differential Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (67, 122, N'DPI-21-30106', N'Differential Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (68, 122, N'DPI-21-30107', N'Differential Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (69, 123, N'DPI-21-30203', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (70, 130, N'DPI-21-31001', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (71, 131, N'DPI-21-31101', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (72, 132, N'DPI-21-31201', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (73, 133, N'DPI-21-31301', N'Differential Pressure Digital')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (74, 104, N'DPI-26-18501-COM', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (75, 104, N'DPI-26-18502-COM', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (76, 104, N'DPI-26-18504-COM', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (77, 104, N'DPI-26-18505-COM', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (78, 104, N'DPI-26-18506-COM', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (79, 104, N'DPI-26-18507-COM', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (80, 116, N'DPI-26-25101', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (81, 116, N'DPI-26-25102', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (82, 116, N'DPI-26-25103', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (83, 116, N'DPI-26-25104', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (84, 116, N'DPI-26-25105', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (85, 116, N'DPI-26-25106', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (86, 116, N'DPI-26-25107', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (87, 116, N'DPI-26-25108', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (88, 119, N'DPI-26-25701', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (89, 63, N'DPI-31-11401', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (90, 63, N'DPI-31-11402', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (91, 63, N'DPI-31-11403', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (92, 63, N'DPI-31-11404', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (93, 67, N'DPI-33-13302', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (94, 67, N'DPI-33-13303', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (95, 67, N'DPI-33-13304-MOV', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (96, 67, N'DPI-33-13305', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (97, 142, N'DPI-33-32801', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (98, 142, N'DPI-33-32802', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (99, 142, N'DPI-33-32803', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (100, 63, N'DPI-41-11405', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (101, 63, N'DPI-41-11406', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (102, 118, N'DPI-42-25601-BSC', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (103, 75, N'DPS-24-14001', N'Differential Pressure Switch')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (104, 75, N'DPS-24-14002', N'Differential Pressure Switch')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (105, 75, N'DPS-24-14003', N'Differential Pressure Switch')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (106, 75, N'DPS-24-14004', N'Differential Pressure Switch')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (107, 8, N'DPT-13-33305', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (108, 11, N'DPT-13-33308', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (109, 5, N'DPT-13-33314', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (110, 13, N'DPT-13-33320', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (111, 14, N'DPT-13-33323', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (112, 17, N'DPT-13-33326', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (113, 23, N'DPT-13-33328', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (114, 136, N'DPT-21-31701', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (115, 137, N'DPT-21-31801', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (116, 138, N'DPT-21-31901', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (117, 139, N'DPT-21-32101', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (118, 140, N'DPT-21-32301', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (119, 141, N'DPT-21-32401', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (120, 60, N'DPT-22-11001', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (121, 60, N'DPT-22-11002', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (122, 60, N'DPT-22-11003', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (123, 60, N'DPT-22-11004', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (124, 60, N'DPT-22-11005', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (125, 60, N'DPT-22-11006', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (126, 60, N'DPT-22-11007', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (127, 60, N'DPT-22-11008', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (128, 63, N'DPT-31-11401', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (129, 63, N'DPT-31-11402', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (130, 63, N'DPT-31-11403', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (131, 117, N'DPT-42-25301', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (132, 117, N'DPT-42-25302', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (133, 39, N'ENG-INS-16010001', N'Thermometer Calibration KIT')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (134, 37, N'ENG-INS-25DT0047', N'Digital Manometer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (135, 39, N'ENG-INS-58506H', N'Temperature Calibration Block HTR')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (136, 39, N'ENG-INS-58506L', N'Temperature Calibration Block LTR')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (137, 39, N'ENG-INS-ATM301', N'Anak Timbang')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (138, 39, N'ENG-INS-ATM302', N'Anak Timbang')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (139, 39, N'ENG-INS-ATM303', N'Anak Timbang')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (140, 39, N'ENG-INS-ATM304', N'Anak Timbang')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (141, 39, N'ENG-INS-ATM305', N'Anak Timbang')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (142, 92, N'FM-21-16001', N'Flow Meter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (143, 139, N'FM-21-32101', N'Flow Meter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (144, 15, N'FT-13-33301', N'Air Flow Tranmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (145, 16, N'FT-13-33302', N'Air Flow Tranmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (146, 140, N'FT-21-32301', N'Air Flow Sensor')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (147, 69, N'I/P-11-13516.1-JB', N'I/P Converter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (148, 69, N'I/P-11-1353.1-JB', N'I/P Converter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (149, 72, N'I/P-11-13610.10-CB', N'I/P Converter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (150, 72, N'I/P-11-13610.5-CB', N'I/P Converter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (151, 72, N'I/P-11-13615.15-CB', N'I/P Converter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (152, 72, N'I/P-11-13615.1-CB', N'I/P Converter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (153, 72, N'I/P-11-13620-CB', N'I/P Converter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (154, 144, N'PI-11-33402-BMI', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (155, 60, N'PI-21-11011', N'Vacuum  Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (156, 60, N'PI-21-11012', N'Pressure  Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (157, 92, N'PI-21-16002', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (158, 92, N'PI-21-16003', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (159, 130, N'PI-21-31001', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (160, 130, N'PI-21-31002', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (161, 136, N'PI-21-31702', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (162, 139, N'PI-21-32101', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (163, 139, N'PI-21-32102', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (164, 139, N'PI-21-32103', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (165, 139, N'PI-21-32104', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (166, 140, N'PI-21-32301', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (167, 140, N'PI-21-32302', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (168, 60, N'PI-22-11003', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (169, 75, N'PI-24-14005', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (170, 82, N'PI-24-14503', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (171, 82, N'PI-24-14511', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (172, 81, N'PI-25-14401-B', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (173, 81, N'PI-25-14402-B', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (174, 81, N'PI-25-14404-B', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (175, 69, N'PSL-11-1351.1-PT', N'Pressure Switch Low')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (176, 69, N'PSL-11-13530-DMP', N'Pressure Switch Low')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (177, 72, N'PSL-11-13609-PMS', N'Pressure Switch Low')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (178, 72, N'PSL-11-13610-PMS', N'Pressure Switch Low')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (179, 72, N'PSL-11-13611-PMS', N'Pressure Switch Low')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (180, 144, N'PSL-11-33401-BMI', N'Pressure Switch Low')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (181, 144, N'PSL-11-33402-BMI', N'Pressure Switch Low')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (182, 65, N'PSL-23-12373-GET', N'Pressure Switch')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (183, 65, N'PSL-23-12374-GET', N'Pressure Switch')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (184, 119, N'PSL-26-25701-GET', N'Pressure Switch Low')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (185, 119, N'PSL-42-25701', N'Pressure Switch Low')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (186, 119, N'PSL-42-25702', N'Pressure Switch Low')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (187, 72, N'PT-11-13610.1-WPU', N'Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (188, 72, N'PT-11-13615.1-PMS', N'Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (189, 72, N'PT-11-13620-PSG', N'Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (190, 122, N'PT-21-30101', N'Pressure For Convert to Flow Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (191, 140, N'PT-21-32301', N'Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (192, 65, N'PT-23-12303-GET', N'Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (193, 65, N'PT-23-12304-GET', N'Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (194, 78, N'PT-25-14201-KRG', N'Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (195, 63, N'PT-31-11401', N'Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (196, 119, N'PT-42-25701-GET', N'Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (197, 72, N'R-11-13602-PMS', N'Temperature Recorder')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (198, 78, N'R-25-14202-KRG-CH1', N'Recorder')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (199, 78, N'R-25-14202-KRG-CH2', N'Recorder')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (200, 78, N'R-25-14202-KRG-CH3', N'Recorder')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (201, 91, N'RH-21-15802', N'Temperature & RH Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (202, 56, N'RH-41-10201', N'RH Recorder')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (203, 152, N'RH-41-21010', N'RH Recorder')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (204, 152, N'RH-41-21011', N'RH Recorder')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (205, 152, N'RH-41-21012', N'RH Recorder')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (206, 152, N'RH-41-21013', N'RH Recorder')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (207, 152, N'RH-41-21014', N'RH Recorder')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (208, 152, N'RH-41-21015', N'RH Recorder')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (209, 152, N'RH-41-21016', N'RH Recorder')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (210, 152, N'RH-41-21018', N'RH Recorder')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (211, 152, N'RH-41-21019', N'Chamber')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (212, 117, N'RH-42-25301', N'Hygrometer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (213, 147, N'RH-99-5300-001', N'RH Indicator (Hygrometer)')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (214, 147, N'RH-99-5300-002', N'RH Indicator (Hygrometer)')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (215, 124, N'TC-11-30401', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (216, 124, N'TC-11-30402', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (217, 125, N'TC-11-30501-CT', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (218, 144, N'TC-11-33401-HW', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (219, 151, N'TC-19-33201', N'Temperature Control')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (220, 140, N'TC-21-15503', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (221, 90, N'TC-21-15701-DK', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (222, 90, N'TC-21-15702-DK', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (223, 90, N'TC-21-15703-DK', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (224, 90, N'TC-21-15704-DK', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (225, 92, N'TC-21-16004', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (226, 98, N'TC-21-16602', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (227, 100, N'TC-21-16801', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (228, 131, N'TC-21-31101-UHL', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (229, 131, N'TC-21-31102-UHL', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (230, 131, N'TC-21-31103-UHL', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (231, 60, N'TC-22-11001', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (232, 60, N'TC-22-11002', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (233, 60, N'TC-22-11004', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (234, 106, N'TC-27-19102', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (235, 112, N'TC-41-21001-INC', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (236, 114, N'TC-41-21001-OVN', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (237, 112, N'TC-41-21003', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (238, 112, N'TC-41-21004', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (239, 112, N'TC-41-21005', N'Oil Bath')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (240, 152, N'TC-41-21010', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (241, 152, N'TC-41-21011', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (242, 152, N'TC-41-21012', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (243, 152, N'TC-41-21013', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (244, 152, N'TC-41-21014', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (245, 152, N'TC-41-21015', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (246, 152, N'TC-41-21016', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (247, 112, N'TC-41-21017', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (248, 152, N'TC-41-21018', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (249, 152, N'TC-41-21019', N'Chamber')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (250, 112, N'TC-41-21019-FRN', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (251, 120, N'TC-41-21201-WTB', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (252, 119, N'TC-41-21202-HTP', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (253, 121, N'TC-42-25901-INC', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (254, 121, N'TC-42-25901-OVN', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (255, 121, N'TC-42-25902', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (256, 121, N'TC-42-25903-FRI', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (257, 66, N'TC-99-1300-001', N'Temperature Control')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (258, 66, N'TC-99-1300-002', N'Temperature Control')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (259, 66, N'TC-99-1300-003', N'Temperature Control')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (260, 66, N'TC-99-1300-004', N'Temperature Control')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (261, 92, N'THT-21-16001', N'Temperatur Humidity trasmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (262, 92, N'THT-21-16001.', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (263, 99, N'THT-21-16701', N'Temperatur Humidity trasmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (264, 99, N'THT-21-16701.', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (265, 67, N'THT-33-13301', N'Temperatur Humidity trasmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (266, 67, N'THT-33-13301.', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (267, 100, N'TI/RH-21-16801', N'Temperature/Humidity Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (268, 100, N'TI/RH-21-16801.', N'Temperature/Humidity Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (269, 100, N'TI/RH-21-16802', N'Thermohygrometer Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (270, 100, N'TI/RH-21-16802.', N'Thermohygrometer Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (271, 123, N'TI/RH-21-30202', N'Temperature & RH Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (272, 123, N'TI/RH-21-30202.', N'Temperature & RH Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (273, 132, N'TI/RH-21-31201', N'Temperature/Humidity Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (274, 132, N'TI/RH-21-31201.', N'Temperature/Humidity Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (275, 75, N'TI/RH-24-14001', N'Temperature/Humidity Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (276, 75, N'TI/RH-24-14001.', N'Temperature/Humidity Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (277, 67, N'TI/RH-33-13302', N'Thermohygrometer Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (278, 67, N'TI/RH-33-13302.', N'Thermohygrometer Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (279, 142, N'TI/RH-33-32801', N'Temperature/Humidity Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (280, 142, N'TI/RH-33-32801.', N'Temperature/Humidity Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (281, 111, N'TI/RH-41-20901', N'Temperature Room Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (282, 111, N'TI/RH-41-20901.', N'Humidity Room Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (283, 113, N'TI/RH-41-21201', N'Temperature Room Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (284, 113, N'TI/RH-41-21201.', N'Humidity Room Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (285, 114, N'TI/RH-41-21301', N'Temperature Room Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (286, 114, N'TI/RH-41-21301.', N'Humidity Room Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (287, 121, N'TI/RH-42-25910', N'Temperature Room Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (288, 121, N'TI/RH-42-25910.', N'Humidity Room Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (289, 147, N'TI/RH-99-5300-002', N'Thermohygrometer Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (290, 147, N'TI/RH-99-5300-002.', N'Thermohygrometer Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (291, 72, N'TI-12-13601', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (292, 72, N'TI-12-13602', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (293, 72, N'TI-12-13603', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (294, 72, N'TI-12-13604', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (295, 72, N'TI-12-13605', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (296, 72, N'TI-12-13606', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (297, 72, N'TI-12-13607', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (298, 86, N'TI-21-15302', N'Valprobe II Logger Kaye')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (299, 91, N'TI-21-15802', N'Temperature & RH Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (300, 92, N'TI-21-16603', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (301, 98, N'TI-21-16604', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (302, 122, N'TI-21-30101', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (303, 122, N'TI-21-30102', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (304, 122, N'TI-21-30103', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (305, 122, N'TI-21-30104', N'Sensor Bypass Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (306, 134, N'TI-21-31401', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (307, 139, N'TI-21-32101', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (308, 139, N'TI-21-32102', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (309, 139, N'TI-21-32103', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (310, 60, N'TI-22-11001', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (311, 60, N'TI-22-11007', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (312, 65, N'TI-23-12307-GET', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (313, 65, N'TI-23-12307-SPV-GET', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (314, 65, N'TI-23-12312-GET', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (315, 65, N'TI-23-12312-SPV-GET', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (316, 77, N'TI-24-14101', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (317, 78, N'TI-25-14201', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (318, 80, N'TI-25-14401-A', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (319, 80, N'TI-25-14402-A', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (320, 81, N'TI-25-14403-B', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (321, 81, N'TI-25-14404-B', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (322, 106, N'TI-25-19101', N'Temperature Mixing Tank 1000L')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (323, 121, N'TI-26-25901-PRC', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (324, 121, N'TI-26-25902-PRC', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (325, 106, N'TI-27-19101', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (326, 108, N'TI-27-19302', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (327, 156, N'TI-31-10201-WH', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (328, 155, N'TI-31-18101', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (329, 27, N'TI-31-18102', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (330, 62, N'TI-32-11201', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (331, 62, N'TI-32-11202', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (332, 62, N'TI-32-11203', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (333, 62, N'TI-32-11204', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (334, 62, N'TI-32-11205', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (335, 62, N'TI-32-11206', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (336, 62, N'TI-32-11207', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (337, 62, N'TI-32-11208', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (338, 93, N'TI-39-18102-CMGS', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (339, 56, N'TI-41-10201', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (340, 102, N'TI-41-18202', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (341, 103, N'TI-41-18305', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (342, 103, N'TI-41-18306', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (343, 112, N'TI-41-21001', N'Temperature Room Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (344, 112, N'TI-41-21011', N'Thermometer of Pycnometer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (345, 112, N'TI-41-21012', N'Thermometer of Pycnometer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (346, 112, N'TI-41-21013', N'Thermometer of Pycnometer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (347, 112, N'TI-41-21014', N'Thermometer of Pycnometer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (348, 112, N'TI-41-21401', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (349, 119, N'TI-42-21002', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (350, 115, N'TI-42-21702', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (351, 117, N'TI-42-25302', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (352, 117, N'TI-42-25303', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (353, 118, N'TI-42-25602', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (354, 119, N'TI-42-25701-GET', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (355, 119, N'TI-42-25703', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (356, 119, N'TI-42-25705', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (357, 121, N'TI-42-25707', N'BOD Inkubator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (358, 119, N'TI-42-25708-WTB', N'Water Bath')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (359, 121, N'TI-42-25903', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (360, 113, N'TI-42-25907', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (361, 112, N'TI-42-25908', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (362, 121, N'TI-42-25911', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (363, 121, N'TI-42-25912', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (364, 121, N'TI-42-25914', N'Temperature sensor')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (365, 61, N'TI-91-018', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (366, 64, N'TI-91-019', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (367, 61, N'TI-99-1100-003', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (368, 61, N'TI-99-1100-004', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (369, 64, N'TI-99-1200-002', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (370, 66, N'TI-99-1300-005', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (371, 66, N'TI-99-1300-006', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (372, 66, N'TI-99-1300-007', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (373, 66, N'TI-99-1300-008', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (374, 76, N'TI-99-1400-003', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (375, 76, N'TI-99-1400-004', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (376, 93, N'TI-99-1600-002', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (377, 101, N'TI-99-1700-004', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (378, 101, N'TI-99-1700-005', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (379, 101, N'TI-99-1700-006', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (380, 145, N'TI-99-5100-003', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (381, 145, N'TI-99-5100-004', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (382, 83, N'TI-99-5100-005', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (383, 146, N'TI-99-5200-003', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (384, 146, N'TI-99-5200-004', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (385, 148, N'TI-99-5400-002', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (386, 149, N'TI-99-5Q001-003', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (387, 149, N'TI-99-5Q001-004', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (388, 150, N'TI-99-5Q002-003', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (389, 150, N'TI-99-5Q002-004', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (390, 38, N'TI-99-CRXU', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (391, 38, N'TI-99-CRXU-5254372', N'Thermometer Indicator Thermocouple')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (392, 38, N'TI-99-KKTU', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (393, 38, N'TI-99-KKTU-6042937', N'Thermometer Indicator Thermocouple')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (394, 157, N'TI-99-Truck-001', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (395, 58, N'TM-21-10801', N'Timer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (396, 58, N'TM-21-10802', N'Timer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (397, 122, N'TM-21-30101', N'Sensor Current Step Time Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (398, 138, N'TM-21-31901', N'Timer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (399, 138, N'TM-21-31903', N'Timer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (400, 138, N'TM-21-31904', N'Timer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (401, 119, N'TM-26-25701', N'Timer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (402, 78, N'TSL-25-14201', N'Temperature Switch')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (403, 109, N'TT-12-20301', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (404, 110, N'TT-12-20401', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (405, 126, N'TT-12-30601', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (406, 127, N'TT-12-30701', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (407, 128, N'TT-12-30801', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (408, 129, N'TT-12-30901', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (409, 130, N'TT-12-31001', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (410, 91, N'TT-21-15801-UHL', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (411, 91, N'TT-21-15802-UHL', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (412, 91, N'TT-21-15803-UHL', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (413, 130, N'TT-21-31001', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (414, 130, N'TT-21-31002', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (415, 130, N'TT-21-31003', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (416, 130, N'TT-21-31004', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (417, 140, N'TT-21-32301', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (418, 140, N'TT-21-32302', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (419, 140, N'TT-21-32303', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (420, 60, N'TT-22-11001', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (421, 60, N'TT-22-11002', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (422, 60, N'TT-22-11003', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (423, 60, N'TT-22-11004', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (424, 60, N'TT-22-11005', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (425, 60, N'TT-22-11006', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (426, 60, N'TT-22-11007', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (427, 60, N'TT-22-11008', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (428, 60, N'TT-22-11009', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (429, 65, N'TT-23-12303-GET', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (430, 78, N'TT-25-14201-KRG', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (431, 119, N'TT-26-25702-GET', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (432, 119, N'TT-26-25703-GET', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (433, 56, N'TT-31-10201', N'Temperatur Trasmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (434, 56, N'TT-31-10202', N'Temperatur Trasmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (435, 56, N'TT-31-10204', N'Temperatur Trasmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (436, 56, N'TT-31-10205', N'Temperatur Trasmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (437, 56, N'TT-31-10206', N'Temperatur Trasmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (438, 56, N'TT-31-10207', N'Temperatur Trasmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (439, 56, N'TT-31-10208', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (440, 117, N'TT-42-25301', N'Temperature Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (441, 86, N'WS-21-13701', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (442, 86, N'WS-21-13702', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (443, 86, N'WS-21-13703', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (444, 86, N'WS-21-13704', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (445, 86, N'WS-21-13705', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (446, 86, N'WS-21-13706', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (447, 86, N'WS-21-13707', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (448, 86, N'WS-21-13708', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (449, 107, N'WS-21-13709', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (450, 107, N'WS-21-13710', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (451, 107, N'WS-21-13711', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (452, 79, N'WS-21-13712', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (453, 79, N'WS-21-13713', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (454, 79, N'WS-21-13714', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (455, 79, N'WS-21-13715', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (456, 79, N'WS-21-13716', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (457, 79, N'WS-21-13717', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (458, 74, N'WS-21-13718', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (459, 60, N'WS-21-13719', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (460, 60, N'WS-21-13720', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (461, 60, N'WS-21-13721', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (462, 60, N'WS-21-13722', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (463, 60, N'WS-21-13723', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (464, 60, N'WS-21-13724', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (465, 60, N'WS-21-13725', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (466, 60, N'WS-21-13726', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (467, 60, N'WS-21-13727', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (468, 60, N'WS-21-13728', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (469, 60, N'WS-21-13729', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (470, 60, N'WS-21-13730', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (471, 60, N'WS-21-13731', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (472, 60, N'WS-21-13732', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (473, 60, N'WS-21-13733', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (474, 60, N'WS-21-13734', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (475, 74, N'WS-21-13736', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (476, 74, N'WS-21-13737', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (477, 74, N'WS-21-13738', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (478, 86, N'WS-21-13739', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (479, 86, N'WS-21-13740', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (480, 86, N'WS-21-13741', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (481, 86, N'WS-21-13742', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (482, 86, N'WS-21-13743', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (483, 86, N'WS-21-13744', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (484, 86, N'WS-21-13745', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (485, 86, N'WS-21-13746', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (486, 67, N'WS-31-17701', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (487, 67, N'WS-33-13307', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (488, 67, N'WS-33-13308', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (489, 67, N'WS-33-13309', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (490, 67, N'WS-33-13310', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (491, 67, N'WS-33-13311', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (492, 67, N'WS-33-13313', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (493, 67, N'WS-33-13319', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (494, 67, N'WS-33-13322', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (495, 67, N'WS-33-13323', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (496, 67, N'WS-33-13325', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (497, 67, N'WS-33-13326', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (498, 67, N'WS-33-13327', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (499, 67, N'WS-33-13328', N'Weight')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (500, 66, N'WS-39-001', N'Anak Timbang F1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (501, 66, N'WS-39-002', N'Anak Timbang F1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (502, 66, N'WS-39-003', N'Anak Timbang M1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (503, 66, N'WS-39-004', N'Anak Timbang M1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (504, 118, N'WS-42-25701', N'Anak Timbangan')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (505, 118, N'WS-42-25702', N'Anak Timbangan')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (506, 118, N'WS-42-25703', N'Anak Timbangan')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (507, 118, N'WS-42-25704', N'Anak Timbangan')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (508, 121, N'TI-42-25915', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (509, 160, N'PI-11-33201', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (510, 160, N'PI-11-33202', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (511, 140, N'DPI-21-32301', N'Differential Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (512, 125, N'PI-11-30501-OFA', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (513, 125, N'PI-11-30502-OFA', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (514, 125, N'PI-11-30503-OFA', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (515, 125, N'PI-11-30504-OFA', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (516, 125, N'PI-11-30505-OFA', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (517, 144, N'PI-11-33401-BMI', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (518, 144, N'PI-11-33401-HD', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (519, 144, N'PI-11-33402-HD', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (520, 144, N'PI-11-33402-TK', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (521, 144, N'PI-11-33403-BMI', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (522, 144, N'PI-11-33404-BMI', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (523, 144, N'PSL-11-33403', N'Pressure Switch Low')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (524, 125, N'SV-11-30501-OFA', N'Safety Valve')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (525, 125, N'SV-11-30502-OFA', N'Safety Valve')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (526, 69, N'TC-11-1356.1-CB', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (527, 69, N'TC-11-1356.2-CB', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (528, 73, N'TC-23-13701', N'Temperature Controller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (529, 144, N'TI-11-33401-BMI', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (530, 144, N'TI-11-33401-HW', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (531, 144, N'TI-11-33402-BMI', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (532, 144, N'TI-11-33403-BMI', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (533, 144, N'TI-11-33404-BMI', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (534, 144, N'TI-11-33405-BMI', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (535, 144, N'TI-11-33406-BMI', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (536, 138, N'PI-21-31901', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (537, 140, N'PI-21-32304', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (538, 140, N'PI-21-32305', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (539, 140, N'PI-21-32306', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (540, 137, N'PI-21-31801', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (541, 141, N'PI-21-32401', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (542, 141, N'PI-21-32402', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (543, 141, N'PI-21-32403', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (544, 141, N'PI-21-32404', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (545, 141, N'PI-21-32405', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (546, 138, N'TM-21-31902', N'Timer Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (547, 122, N'PT-21-30102', N'Pressure For Convert to Flow Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (548, 122, N'TI-21-30105', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (549, 140, N'PI-21-32307', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (550, 138, N'PI-21-31902', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (551, 138, N'PI-21-31903', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (552, 137, N'PI-21-31802', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (553, 4, N'DPI-12-20502A-BF1', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (554, 5, N'DPI-12-20502B-BF1', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (555, 4, N'DPI-12-20503A-BF2', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (556, 5, N'DPI-12-20503B-BF2', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (557, 4, N'DPI-12-20504A-HF', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (558, 5, N'DPI-12-20504B-HF', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (559, 122, N'DPI-12-30101-GLT', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (560, 122, N'DPI-12-30102-GLT', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (561, 7, N'DPI-12-30401-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (562, 7, N'DPI-12-30402-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (563, 7, N'DPI-12-30403-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (564, 11, N'DPI-12-30701-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (565, 11, N'DPI-12-30702-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (566, 11, N'DPI-12-30703-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (567, 11, N'DPI-12-30901-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (568, 11, N'DPI-12-30902-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (569, 11, N'DPI-12-30903-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (570, 11, N'DPI-12-30904-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (571, 11, N'DPI-12-30905-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (572, 11, N'DPI-12-30906-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (573, 11, N'DPI-12-30907-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (574, 11, N'DPI-12-30908-AHU', N'Differential Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (575, 133, N'DPI-21-31301-LAF', N'Differential Pressure')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (576, 7, N'DPT-13-33301', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (577, 7, N'DPT-13-33302', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (578, 8, N'DPT-13-33303', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (579, 8, N'DPT-13-33304', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (580, 11, N'DPT-13-33306', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (581, 11, N'DPT-13-33307', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (582, 4, N'DPT-13-33309', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (583, 4, N'DPT-13-33310', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (584, 4, N'DPT-13-33311', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (585, 5, N'DPT-13-33312', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (586, 5, N'DPT-13-33313', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (587, 21, N'DPT-13-33315', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (588, 21, N'DPT-13-33316', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (589, 12, N'DPT-13-33317', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (590, 13, N'DPT-13-33318', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (591, 13, N'DPT-13-33319', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (592, 14, N'DPT-13-33321', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (593, 14, N'DPT-13-33322', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (594, 17, N'DPT-13-33324', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (595, 17, N'DPT-13-33325', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (596, 23, N'DPT-13-33327', N'Differential Pressure Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (597, 69, N'PI-11-13501-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (598, 69, N'PI-11-13501-RO', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (599, 69, N'PI-11-13502-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (600, 69, N'PI-11-13502-RO', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (601, 69, N'PI-11-13503-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (602, 69, N'PI-11-13503-RO', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (603, 69, N'PI-11-13504-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (604, 69, N'PI-11-13504-RO', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (605, 69, N'PI-11-13505-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (606, 69, N'PI-11-13506-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (607, 69, N'PI-11-1351.1-PT', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (608, 69, N'PI-11-1351.2-PT', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (609, 69, N'PI-11-13516.2', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (610, 69, N'PI-11-1353.1-PT', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (611, 69, N'PI-11-1353.2-PT', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (612, 69, N'PI-11-1355.1A-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (613, 69, N'PI-11-1355.1B-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (614, 69, N'PI-11-1355.2A-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (615, 69, N'PI-11-1355.2B-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (616, 69, N'PI-11-1355.3A-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (617, 69, N'PI-11-1355.3B-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (618, 69, N'PI-11-1355.4A-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (619, 69, N'PI-11-1355.4B-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (620, 69, N'PI-11-1356.1A-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (621, 69, N'PI-11-1356.1B-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (622, 69, N'PI-11-1356.2A-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (623, 69, N'PI-11-1356.2B-DMP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (624, 72, N'PI-11-136011-PMS', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (625, 72, N'PI-11-136020.1-PSG', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (626, 72, N'PI-11-136020-PSG', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (627, 72, N'PI-11-13609-PMS', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (628, 72, N'PI-11-13610.1-PWU', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (629, 72, N'PI-11-13610.2-PWU', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (630, 72, N'PI-11-13615.1-PWU', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (631, 72, N'PI-11-13615.2-PMS', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (632, 124, N'PI-11-30401-CH', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (633, 124, N'PI-11-30402-CH', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (634, 124, N'PI-11-30403-CH', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (635, 124, N'PI-11-30404-CH', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (636, 124, N'PI-11-30405-CH', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (637, 124, N'PI-11-30406-CH', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (638, 125, N'PI-11-30501-CH', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (639, 125, N'PI-11-30502-CH', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (640, 125, N'PI-11-30503-CH', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (641, 125, N'PI-11-30504-CH', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (642, 125, N'PI-11-30505-CH', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (643, 126, N'PI-11-30601', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (644, 126, N'PI-11-30602', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (645, 126, N'PI-11-30603', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (646, 126, N'PI-11-30604', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (647, 126, N'PI-11-30605', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (648, 126, N'PI-11-30606', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (649, 126, N'PI-11-30607', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (650, 126, N'PI-11-30608', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (651, 144, N'PI-11-33403-HD', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (652, 144, N'PI-11-33404-HD', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (653, 144, N'PI-11-33405-HD', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (654, 144, N'PI-11-33406-HD', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (655, 144, N'PI-11-33407-HD', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (656, 20, N'PI-12-20101', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (657, 20, N'PI-12-20102', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (658, 20, N'PI-12-20103', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (659, 20, N'PI-12-20104', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (660, 6, N'PI-12-20301', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (661, 6, N'PI-12-20302', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (662, 9, N'PI-12-20401', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (663, 9, N'PI-12-20402', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (664, 1, N'PI-12-30101', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (665, 1, N'PI-12-30102', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (666, 3, N'PI-12-30301', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (667, 3, N'PI-12-30302', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (668, 3, N'PI-12-30303', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (669, 3, N'PI-12-30304', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (670, 7, N'PI-12-30401', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (671, 7, N'PI-12-30402', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (672, 8, N'PI-12-30501', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (673, 8, N'PI-12-30502', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (674, 10, N'PI-12-30601', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (675, 10, N'PI-12-30602', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (676, 70, N'PI-13-40001-CHO', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (677, 70, N'PI-13-40002-CHO', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (678, 70, N'PI-13-40003-CHO', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (679, 70, N'PI-13-40004-CHO', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (680, 68, N'PI-16-30001-BC', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (681, 68, N'PI-16-30001-TC', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (682, 68, N'PI-16-30002-SC', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (683, 143, N'PI-17-13402-WT', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (684, 68, N'PI-17-13403-HWT', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (685, 143, N'PI-17-33201', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (686, 143, N'PI-17-33202', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (687, 143, N'PI-17-33203', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (688, 143, N'PI-17-33204', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (689, 143, N'PI-17-33205', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (690, 143, N'PI-17-33206', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (691, 161, N'PI-17-40001-HP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (692, 161, N'PI-17-40001-PG', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (693, 161, N'PI-17-40002-HP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (694, 161, N'PI-17-40002-PG', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (695, 161, N'PI-17-40003-HP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (696, 161, N'PI-17-40003-SF', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (697, 161, N'PI-17-40004-SF', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (698, 161, N'PI-17-40005-FP', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (699, 126, N'PI-19-30601', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (700, 126, N'PI-19-30602', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (701, 126, N'PI-19-30603', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (702, 126, N'PI-19-30604', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (703, 126, N'PI-19-30605', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (704, 126, N'PI-19-30606', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (705, 126, N'PI-19-30607', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (706, 126, N'PI-19-30608', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (707, 126, N'PI-19-30609', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (708, 161, N'PI-19-33201', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (709, 161, N'PI-19-33202', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (710, 84, N'PI-21-15101', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (711, 84, N'PI-21-15102', N'Vacuum Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (712, 87, N'PI-21-15401', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (713, 87, N'PI-21-15403', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (714, 87, N'PI-21-15404', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (715, 88, N'PI-21-15501', N'Vacuum  Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (716, 91, N'PI-21-15801-UHL', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (717, 91, N'PI-21-15802-UHL', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (718, 91, N'PI-21-15803-UHL', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (719, 91, N'PI-21-15804-UHL', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (720, 98, N'PI-21-16601', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (721, 98, N'PI-21-16602', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (722, 98, N'PI-21-16603', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (723, 98, N'PI-21-16604', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (724, 130, N'PI-21-31003', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (725, 131, N'PI-21-31101-UHL', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (726, 131, N'PI-21-31102-UHL', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (727, 136, N'PI-21-31701', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (728, 140, N'PI-21-32303', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (729, 60, N'PI-22-11001', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (730, 60, N'PI-22-11002', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (731, 60, N'PI-22-11004', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (732, 65, N'PI-23-12301', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (733, 65, N'PI-23-12301-GET', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (734, 65, N'PI-23-12302-GET', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (735, 65, N'PI-23-12302-GNR', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (736, 65, N'PI-23-12303-GET', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (737, 65, N'PI-23-12304-GET', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (738, 65, N'PI-23-12305-GET', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (739, 78, N'PI-25-30001-KRG', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (740, 78, N'PI-25-30002-KRG', N'Pressure Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (741, 80, N'PI-29-144A01', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (742, 119, N'PI-42-25701', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (743, 119, N'PI-42-25702', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (744, 126, N'PS-11-30601', N'Pressure Switch')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (745, 126, N'PS-11-30602', N'Pressure Switch')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (746, 126, N'PS-11-30603', N'Pressure Switch')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (747, 126, N'PS-11-30604', N'Pressure Switch')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (748, 143, N'PSL-17-33201', N'Pressure Switch Low')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (749, 143, N'PSL-17-33202', N'Pressure Switch Low')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (750, 143, N'PSL-17-33203', N'Pressure Switch')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (751, 62, N'RH-32-11208', N'Humidity Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (752, 143, N'SV-17-33201', N'Safety Valve')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (753, 143, N'SV-17-33202', N'Safety Valve')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (754, 7, N'THT-13-33301', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (755, 7, N'THT-13-33301.', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (756, 4, N'THT-13-33303', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (757, 4, N'THT-13-33303.', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (758, 15, N'THT-13-33304', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (759, 5, N'THT-13-33305', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (760, 5, N'THT-13-33305.', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (761, 22, N'THT-13-33306', N'Temperatur Humidity trasmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (762, 22, N'THT-13-33306.', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (763, 15, N'THT-13-33308', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (764, 8, N'THT-13-33309', N'Temperatur Humidity trasmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (765, 8, N'THT-13-33309.', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (766, 16, N'THT-13-33314', N'Temperature Humidity Transmitter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (767, 18, N'TI-11-30401-CH', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (768, 18, N'TI-11-30402-CH', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (769, 18, N'TI-11-30403-CH', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (770, 18, N'TI-11-30404-CH', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (771, 19, N'TI-11-30501-CH', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (772, 19, N'TI-11-30502-CH', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (773, 19, N'TI-11-30503-CH', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (774, 126, N'TI-11-30601', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (775, 126, N'TI-11-30602', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (776, 2, N'TI-12-20101', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (777, 2, N'TI-12-20102', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (778, 2, N'TI-12-20103', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (779, 2, N'TI-12-20104', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (780, 6, N'TI-12-20301', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (781, 6, N'TI-12-20302', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (782, 9, N'TI-12-20401', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (783, 9, N'TI-12-20402', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (784, 1, N'TI-12-30101', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (785, 1, N'TI-12-30102', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (786, 3, N'TI-12-30302', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (787, 3, N'TI-12-30303', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (788, 3, N'TI-12-30304', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (789, 7, N'TI-12-30401', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (790, 7, N'TI-12-30402', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (791, 8, N'TI-12-30501', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (792, 8, N'TI-12-30502', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (793, 10, N'TI-12-30601', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (794, 10, N'TI-12-30602', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (795, 71, N'TI-13-40001-CHO', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (796, 71, N'TI-13-40002-CHO', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (797, 71, N'TI-13-40003-CHO', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (798, 71, N'TI-13-40004-CHO', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (799, 68, N'TI-14-13401-BBL', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (800, 68, N'TI-15-13401-L', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (801, 68, N'TI-15-13402-L', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (802, 68, N'TI-15-13403-L', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (803, 68, N'TI-17-13401-HWT', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (804, 68, N'TI-17-13402-HWT', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (805, 68, N'TI-17-30001-STM', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (806, 65, N'TI-23-12301-WFI', N'Temperature Gauge')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (807, 84, N'TM-21-15101', N'Timer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (808, 84, N'TM-21-15102', N'Timer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (809, 84, N'TM-21-15103', N'Timer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (810, 84, N'TM-21-15104', N'Timer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (811, 87, N'TM-21-15401', N'Timer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (812, 87, N'TM-21-15402', N'Timer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (813, 87, N'TM-21-15404', N'Timer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (814, 96, N'PI-21-16401', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (815, 59, N'PI-21-10901', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (816, 94, N'PI-21-16201', N'Pressure Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (817, 78, N'TI-25-14202', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (818, 105, N'TI-25-19102', N'Temperature Indicator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (819, 159, N'AC-001', N'Dehumidifier 14-2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (820, 159, N'AC-002', N'Dehumidifier 9-3')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (821, 45, N'AC-015', N'Level Control Valve')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (822, 45, N'AC-016', N'AHU System 3')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (823, 45, N'AC-017', N'AHU System 5')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (824, 45, N'AC-018', N'AHU System 14 A')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (825, 45, N'AC-019', N'AHU System 14 B')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (826, 45, N'AC-021', N'AHU System 15')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (827, 45, N'AC-022', N'AHU System 16')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (828, 45, N'AC-023', N'AHU System 17')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (829, 45, N'AC-024', N'AHU System 18')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (830, 45, N'AC-026', N'AHU System 20')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (831, 45, N'AC-027', N'Exhaust Fan System 4')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (832, 45, N'AC-050', N'Fan Toilet')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (833, 166, N'AC-052', N'AHU System 23')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (834, 45, N'AC-055', N'AHU System 9-1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (835, 45, N'AC-056', N'AHU System 9-2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (836, 45, N'AC-058', N'AHU System 24.1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (837, 45, N'AC-059', N'AHU System 24.2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (838, 45, N'AC-060', N'Dehumidifier 24.2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (839, 45, N'AC-061', N'AHU System 25')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (840, 45, N'AC-062', N'AHU System 26')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (841, 45, N'AC-063', N'AHU System 27')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (842, 45, N'AC-064', N'AHU System 28')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (843, 26, N'AC-065', N'Dehumidifier 1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (844, 26, N'AC-066', N'Dehumidifier 2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (845, 167, N'AC-067', N'Dehumidifier')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (846, 26, N'AC-068', N'Air Conditioner 1300A')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (847, 26, N'AC-069', N'Air Conditioner 1300B')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (848, 26, N'AC-070', N'Air Conditioner 1300C')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (849, 26, N'AC-071', N'Air Conditioner 1300D')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (850, 162, N'CSV-004-00', N'BMS Gandaria SCADA/BMS web View')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (851, 33, N'U-002', N'Fuel Trans.Pump')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (852, 33, N'U-004', N'Battery Charger')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (853, 51, N'U-005', N'Fuel Main Tank 1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (854, 159, N'U-015', N'Air Compressor 1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (855, 159, N'U-016', N'Air Compressor 2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (856, 159, N'U-018-1', N'Air Dryer 1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (857, 159, N'U-018-2', N'Air Dryer 2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (858, 159, N'U-019', N'Hot Water Mixing Tank')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (859, 159, N'U-020', N'Hot Water Pump')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (860, 159, N'U-021', N'Hot Water Storage Tank')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (861, 159, N'U-021-2', N'Potable Water Tank A')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (862, 159, N'U-022', N'Submersible Pump No.2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (863, 159, N'U-024', N'Well W. Main Tank 50 M3')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (864, 159, N'U-025', N'Well W. Main Tank 100 M3')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (865, 159, N'U-026', N'Transfer Pump')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (866, 159, N'U-027', N'Degisifier')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (867, 159, N'U-028', N'Clorinator')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (868, 159, N'U-029', N'Sand Filter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (869, 159, N'U-030', N'Daily Well Water Pump 1 (PW A)')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (870, 159, N'U-031', N'Daily Well Water Pump 2 (PW B)')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (871, 51, N'U-034', N'N2 Liquid Tank')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (872, 51, N'U-035', N'N2 Filter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (873, 159, N'U-036', N'Demi Plant Unit')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (874, 159, N'U-037', N'PSG Unit')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (875, 159, N'U-038', N'Neutralizer Unit')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (876, 51, N'U-039', N'Stand by cold water pump A')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (877, 45, N'U-040', N'AHU sytem 21.1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (878, 45, N'U-041', N'AHU system 22.2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (879, 159, N'U-042', N'Oil Free Air ZT-37')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (880, 159, N'U-043-1', N'Blower 1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (881, 159, N'U-043-2', N'Blower 2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (882, 159, N'U-044', N'Sand Filter Pump Waste Water 1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (883, 159, N'U-045', N'Carbon Filter Pump Waste Water 2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (884, 159, N'U-046', N'Electric Drying')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (885, 41, N'U-047', N'Washing Machine')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (886, 41, N'U-048', N'Draying machine')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (887, 53, N'U-049', N'Floor Polisher')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (888, 161, N'U-050', N'Holding Tank Air Compressor')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (889, 159, N'U-052', N'Waste Water Pump')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (890, 159, N'U-055', N'WPU tank and loop')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (891, 159, N'U-056', N'WFI tank and loop')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (892, 159, N'U-057', N'WFI production')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (893, 51, N'U-058-1', N'Jocky pump')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (894, 28, N'U-067', N'Lift')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (895, 159, N'U-070', N'Fuel Main Tank 2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (896, 159, N'U-075', N'Trane 1 Chiller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (897, 159, N'U-075-2', N'Trane 2 Chiller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (898, 159, N'U-076', N'Cooling water pump 1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (899, 159, N'U-077', N'Chiller water pump 1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (900, 51, N'U-078', N'Water Cooler LBC 500')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (901, 153, N'U-079', N'Hand Dryer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (902, 159, N'U-080', N'Tapproge CCS 1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (903, 159, N'U-080-2', N'Tapproge CCS 2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (904, 159, N'U-081', N'Reverse Osmosis Demin')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (905, 159, N'U-082', N'Holding Tank Oil Free')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (906, 159, N'U-083', N'Cooling water pump 2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (907, 159, N'U-084', N'Chiller water pump 2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (908, 43, N'U-085', N'Hand Dryer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (909, 43, N'U-086', N'Hand Dryer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (910, 31, N'U-087', N'Hand Dryer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (911, 31, N'U-088', N'Hand Dryer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (912, 158, N'U-089', N'Hand Dryer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (913, 45, N'U-090', N'Compressed Air Dryer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (914, 161, N'U-091', N'Holding Tank for Boiler')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (915, 161, N'U-096', N'Miura Boiler 1')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (916, 161, N'U-097', N'Miura Boiler 2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (917, 161, N'U-098', N'Reverse Osmosis Raw Water')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (918, 161, N'U-099', N'Carbon Filter Raw Water')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (919, 161, N'U-100', N'Dessicant Dryer')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (920, 161, N'U-101', N'OFA Compressor Water Lubricated')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (921, 161, N'U-102', N'Yamaha Sand & Corbon Water Filter')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (922, 161, N'U-104', N'Water Filter 5 Âµ for Mitshui Seiki Compressor')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (923, 36, N'U-107', N'Vacuum Cleaner Delvin')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (924, 55, N'U-108', N'Vacuum Cleaner Krisbow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (925, 161, N'U-109', N'Potable Water Tank B')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (926, 51, N'U-110', N'Water Cooling Tower LRC 250')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (927, 161, N'U-111', N'AiCool Chiller')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (928, 161, N'U-112', N'OFA Compressor Water Lubricated 2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (929, 161, N'U-113', N'Water Filter 5 Âµ for Mitshui Seiki Compressor 2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (930, 161, N'U-114', N'Chlorinator 2')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (931, 33, N'U-115', N'Perkins Genset')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (932, 154, N'HF-31-11401', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (933, 154, N'HF-31-11402', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (934, 154, N'HF-31-11403', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (935, 154, N'HF-31-11404', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (936, 154, N'HF-31-11405', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (937, 154, N'HF-31-11406', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (938, 154, N'HF-31-11407', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (939, 154, N'HF-31-11408', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (940, 154, N'HF-31-11409', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (941, 48, N'HF-25-14301-P20', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (942, 48, N'HF-25-14302-P20', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (943, 48, N'HF-25-14303', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (944, 48, N'HF-25-14304', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (945, 54, N'HF-25-14201', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (946, 54, N'HF-25-14202', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (947, 40, N'HF-21605', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (948, 46, N'HF-26-25301', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (949, 34, N'HF-26-25401', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (950, 24, N'HF-26-25501', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (951, 46, N'HF-26-25601', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (952, 164, N'HF-25-14401-A', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (953, 49, N'HF-25-14401-B', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (954, 49, N'HF-25-14402-B', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (955, 168, N'HF-23-12301-P21', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (956, 168, N'HF-23-12302-P21', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (957, 168, N'HF-23-12303-P21', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (958, 168, N'HF-23-12304-P21', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (959, 168, N'HF-23-12305-P21', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (960, 42, N'HF-23-12301-PI7', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (961, 42, N'HF-23-12302-PI7', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (962, 42, N'HF-23-12303-P17', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (963, 42, N'HF-23-12304-PI7', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (964, 34, N'HF-24-12703', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (965, 24, N'HF-24-12803', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (966, 30, N'HF-24-12605', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (967, 30, N'HF-24-12606', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (968, 163, N'HF-24-12903', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (969, 165, N'HF-24-14014', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (970, 165, N'HF-24-14015', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (971, 165, N'HF-24-14016', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (972, 165, N'HF-24-14017', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (973, 50, N'HF-24-14108', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (974, 50, N'HF-24-14109', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (975, 32, N'HF-24-14503', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (976, 50, N'HF-24-14101-PI9', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (977, 50, N'HF-24-14102-PI9', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (978, 50, N'HF-24-14103-PI9', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (979, 50, N'HF-24-14104-PI9', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (980, 165, N'HF-24-14005-PI8', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (981, 165, N'HF-24-14006-PI8', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (982, 165, N'HF-24-14007-PI8', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (983, 165, N'HF-24-14008-PI8', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (984, 165, N'HF-24-14009-P18', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (985, 165, N'HF-24-12501-P25', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (986, 29, N'HF-24-12502-P25', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (987, 29, N'HF-24-12503-P25', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (988, 29, N'HF-24-12504-P25', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (989, 29, N'HF-24-12505-P25', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (990, 29, N'HF-24-12506-P25', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (991, 29, N'HF-24-12507-P25', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (992, 29, N'HF-24-12508-P25', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (993, 47, N'HF-24003-MOB', N'Laminar Air Flow')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (994, 35, N'HF-42-25301', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (995, 35, N'HF-42-25302', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (996, 25, N'HF-42-25601-BSC', N'HEPA Ceiling')
INSERT [dbo].[tag] ([id], [area_id], [tagnum], [desct]) VALUES (997, 25, N'HF-42-25602-BSC', N'HEPA Ceiling')
SET IDENTITY_INSERT [dbo].[tag] OFF
END
GO


/** CHECK IF THERES HAS ERROR **/
PRINT ''
IF (@@ERROR != 0) update #test set hasError=1
select * from #test
IF(select * from #test) = 0
  BEGIN
    PRINT 'COMMIT..'
    COMMIT TRANSACTION
  END
ELSE
  BEGIN
    PRINT 'ROLLBACK!'
    ROLLBACK TRANSACTION
  END
--IF (@@ERROR != 0) rollback transaction;
--SET @HAS_ERROR = @@ERROR
--PRINT @HAS_ERROR

--END
--commit transaction
drop table #test
PRINT 'DONE..'
