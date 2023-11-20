Install-Module LDAPCmdlets


#hostname abxads002
#ldap server int.atosbox.ru
#INT\sabx130-ldap
#password=P@YDd1YFywWTjO4K3zUNUc
#get all users from active

$ldap = Connect-LDAP  -User "INT\sabx130-ldap" -Password "P@YDd1YFywWTjO4K3zUNUc" -Server "abxads002.int.atosbox.ru" -Port "389"
$ldap = Connect-LDAP  -User "sabx130-ldap@int.atosbox.ru" -Password "P@YDd1YFywWTjO4K3zUNUc" -Server "abxads002.int.atosbox.ru" -Port "389"

$cn = "Administrator"
$user = Select-LDAP -Connection $ldap -Table "User" -Where "CN = `'$CN`'"
$user

$user = Invoke-LDAP -Connection $ldap -Query 'SELECT * FROM User WHERE CN = @CN' -Params @{'@CN'='Administrator'}



