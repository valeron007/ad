function Make-Credentials ($Account, $Password)
{   
    New-Object System.Management.Automation.PSCredential (
        $Account, 
        (ConvertTo-SecureString $Password -AsPlainText -Force)
    )    
}

$Credential = Make-Credentials -Account "int\sabx130-ldap" -Password "P@YDd1YFywWTjO4K3zUNUc"

$Filter = "(objectClass=user)"
$RootOU = "OU=Users,OU=ABX,OU=OU_Root,DC=int,DC=atosbox,DC=ru"

$Searcher = New-Object DirectoryServices.DirectorySearcher
$Searcher.SearchRoot = New-Object System.DirectoryServices.DirectoryEntry(
        "LDAP://$($RootOU)",
        $($Credential.UserName),
        $($Credential.GetNetworkCredential().password)
    )
$Searcher.Filter = $Filter
$Searcher.SearchScope = "OneLevel" # Either: "Base", "OneLevel" or "Subtree"
$Searcher.FindAll() 
