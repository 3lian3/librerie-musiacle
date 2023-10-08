<#
.SYNOPSIS
Ce script fournit des fonctions utilitaires et une fonction Help pour afficher leurs descriptions.
#>
# Installe le projet

<#
.SYNOPSIS
Installe le projet en executant les commandes de configuration necessaires.
#>
function my_install {
    symfony composer install
    npm install
    symfony console d:d:c
    my_rebuild
}

# Reconstruit la base de donnees

<#
.SYNOPSIS
Reconstruit la base de donnees en executant les commandes de base de donnees necessaires.
#>
function my_rebuild {
    symfony console d:d:d -f
    symfony console d:d:c
    symfony console d:s:u -f
    symfony console d:f:l -n
}

# Affiche l'aide

<#
.SYNOPSIS
Affiche la liste des fonctions et leurs descriptions.
#>
function Show-Help {
    Get-Command -CommandType Function | Where-Object { $_.Name -like "my_*" } | ForEach-Object {
        $comment = (Get-Help $_.Name).Synopsis
        Write-Host ("{0}: {1}" -f $_.Name, $comment)
    }
}