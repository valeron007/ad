#INT\sabx130-ldap
#password=P@YDd1YFywWTjO4K3zUNUc
Import-Module activedirectory

$UserName = 'INT\sabx130-ldap'
$Password = 'P@YDd1YFywWTjO4K3zUNUc'

Function Test-ADAuthentication {
    param(
        $username,
        $password)
    
    (New-Object DirectoryServices.DirectoryEntry "",$username,$password).psbase.name -ne $null
}

Test-ADAuthentication -username $UserName -password $password

Get-ADUser -Filter * -SearchBase "OU=Users,OU=ABX,OU=OU_Root,DC=int,DC=atosbox,DC=ru"



