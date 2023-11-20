Import-Module activedirectory

//Test-NetConnection -ComputerName abxads002 -InformationLevel "Detailed" -Port 445
#hostname abxads002
#ldap server int.atosbox.ru
#INT\sabx130-ldap
#password=P@YDd1YFywWTjO4K3zUNUc
#get all users from active
$password = "P@YDd1YFywWTjO4K3zUNUc" | ConvertTo-SecureString -asPlainText -Force
$username = "sabx130-ldap"
$cred = New-Object System.Management.Automation.PSCredential($username,$password)

#$Filter = "((mailNickname=id*)(whenChanged>=20170701000000.0Z))(|(userAccountControl=514)(userAccountControl=66050))(|(memberof=CN=VPN,OU=VpnAccess,OU=Domain Global,OU=Groups,OU=01,DC=em,DC=pl,DC=ad,DC=mnl)(memberof=CN=VPN-2,OU=VpnAccess,OU=Domain Global,OU=Groups,OU=01,DC=em,DC=pl,DC=ad,DC=mnl))"
#$RootOU = "OU=Users,OU=ABX,OU=OU_Root,DC=int,DC=atosbox,DC=ru"
<#
$Searcher = New-Object DirectoryServices.DirectorySearcher
$Searcher.SearchRoot = New-Object System.DirectoryServices.DirectoryEntry("LDAP://$($RootOU)")
$Searcher.Filter = $Filter
$Searcher.SearchScope = $Scope # Either: "Base", "OneLevel" or "Subtree"
$Searcher.FindAll()
#>
<#
DirectoryEntry entry = new DirectoryEntry("LDAP://abxads002.int.atosbox.ru");
entry.Username = "int\sabx130-ldap";
entry.Password = "P@YDd1YFywWTjO4K3zUNUc";
DirectorySearcher searcher = new DirectorySearcher(entry);
searcher.Filter = "(&(objectClass=user)(sn=Jones))";
#>
#SearchResultCollection results = searcher.FindAll();

#search root
<#
$LDAPSEARCH = New-Object System.DirectoryServices.DirectorySearcher 
$LDAPSEARCH.SearchRoot = "LDAP://DC=INT,DC=ATOSBOX,DC=RU"
$LDAPSEARCH.FindAll()
#>

Test-NetConnection -ComputerName abxads002.int.atosbox.ru -Port 389



