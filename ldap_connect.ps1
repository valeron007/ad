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

#Prevent display of all errors, not really required
$ErrorActionPreference = "silentlycontinue"

#Create OSD Task Sequence object to create/modify OSD variable values
#$TSEnv = New-Object -Comobject Microsoft.SMS.TSEnvironment
#Get tech provided ComputerNamername from a previous task sequence step
#$CN = $TSEnv.value("OSDComputerName")

#Get Domain Controller IP Address
$DomainIP = (Test-Connection -ComputerName "abxads002.int.atosbox.ru" -Count 1).IPV4Address.IPAddressToString

#Set connection and credential options
$de = New-Object System.DirectoryServices.DirectoryEntry("LDAP://$DomainIP",'INT\A828835','Gtlhbkj0792!')

#filter by users (&(objectCategory=person)(objectClass=user)(!primaryGroupID=513))
#Configure search filter
#OU=Users,OU=ABX,OU=OU_Root,DC=int,DC=atosbox,DC=ru
$searcher = New-Object System.DirectoryServices.DirectorySearcher($de,"(&(objectClass=user))")
//$searcher.PageSize = 500
#Perform search and get Result
$result = $searcher.FindAll()

<#
foreach ($person in $result)
{
    $prop=$person.properties    
    Write-Host $prop.count
    foreach ($pr in $prop)
    {
        #$pr | Get-Member
        $pr.PropertyNames
        break
    }
    Write-host "First name: $($prop.givenname) Surname: $($prop.sn) User: $($prop.cn)"
}
#>
ConvertTo-Json $result -Depth 100 | Out-File "C:\Users\administrator\Desktop\scripts\users1.json"
#Write-host "There are $($result.count) users in the domain"

#Read more: https://www.sharepointdiary.com/2011/12/powershell-script-to-list-all-users.html#ixzz7sjofTNFn

#Read more: https://www.sharepointdiary.com/2011/12/powershell-script-to-list-all-users.html#ixzz7sjoBbPcE

 