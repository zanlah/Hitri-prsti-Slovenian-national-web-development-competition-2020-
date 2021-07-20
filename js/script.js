var crke = ['q','w','e','r','t','z','u','i','o','p','š','a','s','d','f','g','h','j','k','l','č','y','x','c','v','b','n','m']
var besedilo = "smo v trenutkih ko je najpomembnejša le ena zadeva skrb za zdravje Pandemija je ob mnogih drugih ustavila tudi nogometne aktivnosti in ob odgovornem ravnanju z doslednim upoštevanjem navodil želimo kot klub pomagati še na druge načine Nadgradili bomo projekt tradicionalne krvodajalske akcije Vijolična kri za vse ljudi Vsako leto organiziramo plemenita dejanja v septembru tokrat bomo že v marcu V dneh ko medicinsko osebje uspeva z nadčloveškimi napori obvladovati neprijetno situacijo je bistvenega pomena tudi ustrezna zaloga krvi"

function zacni()
{
    // implementiraj
}

function ustavi()
{
    // implementiraj
}

// vrne naključno besedo iz besedila
function generiraj_besedo()
{
    besedilo = besedilo.toLowerCase()
    var besede = besedilo.split(" ")
    
    var index = Math.floor(Math.random() * besede.length)
    
    return besede[index]
}

function prikazi_besede()
{
    // implementiraj
}

function prikazi_tipkovnico()
{
    // implementiraj
}

function pritisk_tipke(koda)
{
    // implementiraj
}

// zgoraj napisane funkcijo so samo za pomoč, 
// lahko si implementirate poljubno število lastnih funkcij

$(() => {

    // implementiraj

})