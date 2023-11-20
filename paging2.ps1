[System.Reflection.assembly]::LoadWithPartialName("system.directoryservices.protocols") | Out-Null
[int]$pageSize = 200
[int]$count = 0


$secpasswd = ConvertTo-SecureString 'Gtlhbkj0792!' -AsPlainText -Force

#$cred = Get-Credential
$Credential = New-Object System.Management.Automation.PSCredential("INT\A828835", $secpasswd)

$Domain = New-Object `
 -TypeName System.DirectoryServices.DirectoryEntry `
 -ArgumentList 'LDAP://abxads002.int.atosbox.ru',
   $($Credential.UserName),
   $($Credential.GetNetworkCredential().password)

$connection = New-Object System.DirectoryServices.Protocols.LdapConnection('LDAP://abxads002.int.atosbox.ru:389')
$connection.AuthType = [System.DirectoryServices.Protocols.AuthType]::Basic
$connection.Bind($Credential);

$subtree = [System.DirectoryServices.Protocols.SearchScope]"Subtree"
$filter = "(&(objectCategory=person)(objectclass=user))"
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