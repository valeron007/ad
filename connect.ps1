<#
fields extensionAttribute11,whenchanged,whencreated,employeetype,manager,preferredlanguage,extensionAttribute5,extensionAttribute4,mobile,distinguishedname,userprincipalname,useraccountcontrol,telephonenumber,sn,
physicaldeliveryofficename,name,mail,l,givenname,personaltitle,employeeNumber,extensionAttribute13,displayname,department,company,co,cn,c,samAccountname
#>


#full name abxads002.int.atosbox.ru
#hostname abxads002
#ldap server int.atosbox.ru
#INT\sabx130-ldap
#password=P@YDd1YFywWTjO4K3zUNUc
#get all users from active
#OU=Users,OU=ABX,OU=OU_Root,DC=int,DC=atosbox,DC=ru
# FROM ''''LDAP://abxads008.int.atosbox.ru'''' WHERE company=''''Atos IT Solutions and Services'''' AND objectclass=''''user'''' AND  objectcategory=''''person'''' AND samAccountname=''''*'''' AND sn = '''''+@sChar+'*'''''')
<#
my user
INT\A828835
password:Gtlhbkj0792!
#>

#filter
<#
(objectCategory=*) 
(&(objectClass=user)) 
#>

# Needs reference to .NET assembly used in the script.
Add-Type -AssemblyName System.DirectoryServices.Protocols
$username = 'cn=A828835'
$pwd = 'Gtlhbkj0792!'
$server = "abxads002.int.atosbox.ru"
$port = "389"
$password = ConvertTo-SecureString 'Gtlhbkj0792!' -AsPlainText -Force
# Top Level OU under which users are located
$ldapSearchBase = "OU=Users,OU=ABX,OU=OU_Root,DC=int,DC=atosbox,DC=ru" 
# Filter to find the user we are connecting with
$ldapSearchFilter = "(&(objectClass=user))"
# Username and Password
$ldapCredentials = New-Object System.Net.NetworkCredential($username,$password)
# Create a Connection
$ldapConnection = New-Object System.DirectoryServices.Protocols.LDAPConnection("$($server):$($port)",$ldapCredentials,"Basic")
# Connect and Search
$ldapTimeOut = new-timespan -Seconds 30
$ldapRequest = New-Object System.DirectoryServices.Protocols.SearchRequest($ldapSearchBase, $ldapSearchFilter, "OneLevel", $null)
$ldapResponse = $ldapConnection.SendRequest($ldapRequest, $ldapTimeOut)
$ldapResponse.Entries[0].Attributes