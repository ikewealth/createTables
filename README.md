# createTables
**
 * @example
 * $tables1 = new Table($conn);
$tables1->setTable_name("admin");
$tables1->setColumn("username", "varchar", 60, "not null ");
$tables1->setColumn("password", "varchar", 70, "not null ");
$tables1->setColumn("login_date","date","","not null");
$tables->create_table();
$tables->alter_table("admin_type","varchar(20) not null ");

 */
