/****** Object:  Table [orders]    Script Date: 11/20/2021 6:58:03 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

DROP TABLE IF EXISTS [RO]
GO
CREATE database RO
GO
USE RO
GO

-- DEPT
DROP TABLE IF EXISTS [dept]
GO
CREATE TABLE [dept](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[code] [nvarchar](50) NULL,
	[label] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_dept_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

-- AREA
CREATE TABLE [area](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[label_a] [nvarchar](255) NOT NULL,
 CONSTRAINT [PK_area_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

-- REGION
CREATE TABLE [region](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[dept_id] [int] NOT NULL,
	[nama] [nvarchar](100) NOT NULL,
 CONSTRAINT [PK_region_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [region] ADD  DEFAULT ((1)) FOR [dept_id]
GO
ALTER TABLE [region]  WITH NOCHECK ADD  CONSTRAINT [region$region_ibfk_1] FOREIGN KEY([dept_id])
REFERENCES [dept] ([id])
GO
ALTER TABLE [region] CHECK CONSTRAINT [region$region_ibfk_1]
GO

-- USER
CREATE TABLE [users](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[username] [nvarchar](255) NOT NULL,
	[fullname] [nvarchar](255) NULL,
	[email] [nvarchar](255) NULL,
	[dept_id] [int] NOT NULL,
	[spv] [int] NULL,
	[status] [smallint] NOT NULL,
	[role] [int] NOT NULL,
	[signature] [nvarchar](50) NULL,
	[priv] [nvarchar](255) NULL,
	[created_at] [int] NOT NULL,
	[updated_at] [int] NULL,
	[last_loged] [int] NULL,
	[auth_key] [nvarchar](50) NULL,
	[password_hash] [nvarchar](255) NULL,
	[access_token] [nvarchar](255) NULL,
	[password_reset_token] [nvarchar](255) NULL,
 CONSTRAINT [PK_user_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [user] ADD  DEFAULT ((1)) FOR [status]
GO
ALTER TABLE [user] ADD  DEFAULT ((2)) FOR [role]
GO

-- TAG
CREATE TABLE [tag](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[area_id] [int] NULL,
	[tagnum] [nvarchar](150) NOT NULL,
	[desct] [nvarchar](255) NOT NULL,
 CONSTRAINT [PK_tag_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [tag]  WITH NOCHECK ADD  CONSTRAINT [tag$tag_ibfk_1] FOREIGN KEY([area_id])
REFERENCES [area] ([id])
GO
ALTER TABLE [tag] CHECK CONSTRAINT [tag$tag_ibfk_1]
GO

-- ORDERS id,assign_to,region_id,initiator_id,dept_id,tag_num,item_desc,area,priority,status,ehs_assest,ehs_hazard,ehs_hazard_risk
CREATE TABLE [orders](
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
	[ehs_assest] [int] NULL,
	[ehs_hazard] [nvarchar](max) NULL,
	[ehs_hazard_risk] [nvarchar](max) NULL,
	[replacement] [nvarchar](max) NULL,
	[create_at] [smalldatetime] NOT NULL,
	[update_at] [smalldatetime] NOT NULL,
	[complete_at] [smalldatetime] NULL,
 CONSTRAINT [PK_orders_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
ALTER TABLE [orders] ADD  DEFAULT (N'N/A') FOR [ehs_hazard]
GO
ALTER TABLE [orders]  WITH NOCHECK ADD  CONSTRAINT [orders$orders_ibfk_1] FOREIGN KEY([dept_id])
REFERENCES [dept] ([id])
GO
ALTER TABLE [orders] CHECK CONSTRAINT [orders$orders_ibfk_1]
GO

-- COMMENTS
CREATE TABLE [comment](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NOT NULL,
	[order_id] [nvarchar](12) NOT NULL,
	[comment] [nvarchar](max) NULL,
	[time] [int] NOT NULL,
 CONSTRAINT [PK_comment_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
ALTER TABLE [comment]  WITH NOCHECK ADD  CONSTRAINT [comment$comment_ibfk_1] FOREIGN KEY([user_id])
REFERENCES [user] ([id])
GO
ALTER TABLE [comment] CHECK CONSTRAINT [comment$comment_ibfk_1]
GO

-- LOG
CREATE TABLE [log](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[date] [smalldatetime] NOT NULL,
	[userid] [int] NULL,
	[event] [nvarchar](255) NOT NULL,
 CONSTRAINT [PK_log_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

-- MIGRATION
CREATE TABLE [migration](
	[version] [nvarchar](180) NOT NULL,
	[apply_time] [int] NULL,
 CONSTRAINT [PK_migration_version] PRIMARY KEY CLUSTERED 
(
	[version] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

--- NEW TABLE
CREATE TABLE [orders2]([id] [nvarchar](12) NOT NULL,[assign_to] [int] NOT NULL,[region_id] [int] NOT NULL,[initiator_id] [int] NOT NULL,[dept_id] [int] NOT NULL,[tag_num] [nvarchar](100) NOT NULL,[item_desc] [nvarchar](255) NOT NULL,[area] [nvarchar](255) NOT NULL,[priority] [smallint] NOT NULL,[status] [smallint] NOT NULL,[title] [nvarchar](255) NOT NULL,[detail_desc] [nvarchar](max) NULL,[ehs_assest] [int] NULL,[ehs_hazard] [nvarchar](255) NULL,[ehs_hazard_risk] [nvarchar](255) NULL,[replacement] [nvarchar](max) NULL,[create_at] [smalldatetime] NOT NULL,[update_at] [smalldatetime] NOT NULL,[complete_at] [smalldatetime] NULL, PRIMARY KEY (id))

-- PRIORIT LIST
CREATE TABLE [priority]([id] [int] IDENTITY(1,1) NOT NULL, [label] [nvarchar](100) NOT NULL, PRIMARY KEY (id))
GO
SET IDENTITY_INSERT [priority] ON ;
INSERT INTO [priority] (id, label) VALUES (1, 'Breakdown'), (2, 'Pro Aktif Maintenance'), (3, 'TPM'), (4, 'Other')
SET IDENTITY_INSERT [priority] Offf ;

-- EHS ASSESTMENT LIST
CREATE TABLE [ehs_ass]([id] [int] IDENTITY(1,1) NOT NULL,[label] [nvarchar](100) NOT NULL, PRIMARY KEY (id))
GO
SET IDENTITY_INSERT [ehs_ass] ON ;
INSERT INTO [ehs_ass] (id, label) VALUES (1, 'Ergonomic / Manual Handling'), (2, 'Penyimpanan & Material Safety'), (3, 'High Hazard Work'), (4, 'Working Equipment'), (5, 'Kesehatan'), (6, 'Occupational Hygiene'), (7, 'Environmental'), (8, 'Safe Workplace'), (9, 'Bahaya Listrik'), (10, 'APD dan Penandaan'), (11, 'Fire and Life Safety'), (12, 'Other')
