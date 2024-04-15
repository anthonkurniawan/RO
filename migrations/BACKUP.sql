DECLARE @DB VARCHAR(20) = 'RO', @DB_BAK VARCHAR(20) = 'RO-BAK'
DECLARE @PATH VARCHAR(200) = 'C:\Program Files\Microsoft SQL Server\MSSQL10.MSSQLSERVER\MSSQL\DATA\'
DECLARE @PATH_DATA VARCHAR(200) = @PATH + @DB_BAK + '.mdf'
DECLARE @PATH_LOG VARCHAR(200) = @PATH + @DB_BAK + '.ldf'
DECLARE @LOGICAL_NAME VARCHAR(100), @LOGICAL_LOG VARCHAR(100)

USE RO

IF (@@ERROR != 0) BEGIN
  PRINT "DATABASE "+@DB+" NOT EXISTS"
  RETURN
END

IF NOT EXISTS (select name from sys.databases where name = @DB_BAK)
  BEGIN
  SET @LOGICAL_NAME = (select file_name(1))
  SET @LOGICAL_LOG = (select file_name(2))

  PRINT "BACKUP "+@DB+" database to "+@DB_BAK
  backup database @DB to disk = 'c:\RO.bak'
  with init, stats =10;

  PRINT "COPY DATABASE "+@DB+" To "+@DB_BAK
  --RESTORE FILELISTONLY FROM disk = 'c:\RO.bak';
  RESTORE database @DB_BAK FROM disk = 'c:\RO.bak'
  with move @LOGICAL_NAME to @PATH_DATA,
  move @LOGICAL_LOG to @PATH_LOG;
  -- EXEC sp_renamedb
  END
  ELSE
  BEGIN
  PRINT "BACKUP "+@DB_BAK+" is exists"
  END

PRINT "DONE.."
GO
