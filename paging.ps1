[System.Reflection.assembly]::LoadWithPartialName("system.directoryservices.protocols") | Out-Null
[int]$pageSize = 200
[int]$count = 0

$DomainIP = (Test-Connection -ComputerName "abxads002.int.atosbox.ru" -Count 1).IPV4Address.IPAddressToString

#Set connection and credential options
$de = New-Object System.DirectoryServices.DirectoryEntry("LDAP://$DomainIP",'INT\A828835','Gtlhbkj0792!')

$secpasswd = ConvertTo-SecureString 'Gtlhbkj0792!' -AsPlainText -Force

$Credential = New-Object System.Management.Automation.PSCredential("INT\A828835", $secpasswd)

$Domain = New-Object `
 -TypeName System.DirectoryServices.DirectoryEntry `
 -ArgumentList 'LDAP://abxads008.int.atosbox.ru',
   $($Credential.UserName),
   $($Credential.GetNetworkCredential().password)
#$Domain = [ADSI]"LDAP://abxads002.int.atosbox.ru"

$connection = New-Object System.DirectoryServices.Protocols.LdapConnection("abxads002.int.atosbox.ru")
$connection.AuthType = [System.DirectoryServices.Protocols.AuthType]::Basic
#$connection.Timeout = 10000
$connection.Bind($Credential)
$subtree = [System.DirectoryServices.Protocols.SearchScope]"Subtree"
#(&(objectClass=user))
#$filter = "(&(objectCategory=person)(objectclass=user))"
$filter = "(&(objectclass=user))"
$searchRequest = New-Object System.DirectoryServices.Protocols.SearchRequest($Domain.distinguishedName,$filter,$subtree,@("1.1"))
$pagedRequest = New-Object System.DirectoryServices.Protocols.PageResultRequestControl($pageSize)
$searchRequest.Controls.add($pagedRequest) | out-null
$searchOptions = new-object System.DirectoryServices.Protocols.SearchOptionsControl([System.DirectoryServices.Protocols.SearchOption]::DomainScope)
$searchRequest.Controls.Add($searchOptions) | out-null

while ($true)
{
    $searchResponse = $connection.SendRequest($searchRequest)
    $pageResponse = $searchResponse.Controls[0]
    $count = $count + $searchResponse.entries.count
    # display the entries within this page.
    foreach($entry in $searchResponse.entries){$entry.DistinguishedName}
    # Check if there are more pages.
    if ($pageResponse.Cookie.Length -eq 0){write-Host $count;break}
    $pagedRequest.Cookie = $pageResponse.Cookie
}