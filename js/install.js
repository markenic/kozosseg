let panel = 0
const checkDatas = () =>{

    if(panel == 0){
        let ip = $("#ip")[0].value
        let dbName = $("#databaseName")[0].value
        let dbUser = $("#databaseUser")[0].value
        let dbPass = $("#databasePass")[0].value
        let dbPort = $("#databasePort")[0].value
        $.ajax({
            url: 'assets/tryToInstall.php',
            type: 'POST',
            data: {
            wData: "database",
            ip:ip,
            dbname:dbName,
            dbuser:dbUser,
            dbpass:dbPass,
            dbport:dbPort
            },
            success: function (msg) {
                console.log(msg)
                msg = JSON.parse(msg)
                if(msg.success){
                    alertify.notify('Sikeres Mysql csatlakozás', 'success', 5)
                    panel = 1
                    $(".installPage")[0].innerHTML = 2 
                    $(".backTo")[0].onclick=function(){backToPanel(0)}
                    $(".progress-bar")[0].style.width="66%"

                    $(".database").css("display","none")
                    $(".school").show("slide", { direction: "left" }, 5000)

                }else{
                                //2002 - Bad IP
                                //1049 - Bad DB
                                //1045 - Bad Username/password
                    if(msg.response=="1045"){
                        alertify.notify("Sikertelen kapcsolódás. ('"+dbUser+"'@'"+(dbName||'localhost')+"')", 'error', 5)
                    }else if(msg.response=="1049"){
                        alertify.notify("Nem létezik a(z) "+dbName+" adatbázis!", 'error', 5)
                    }
                    else if(msg.response=="2002"){
                        alertify.notify("A(z) "+ip+" célcím elutasította a kapcsolódást, vagy nem lehet létrehozni azt!", 'error', 5)
                    }
                }
            }
        })
    }else if(panel==1){
        let name = $(".sname")[0].value
        let shortName = $(".shortname")[0].value
        let email = $(".semail")[0].value
        let phonenumber = $(".sphone")[0].value
        $.ajax({
            url: 'assets/tryToInstall.php',
            type: 'POST',
            data: {
                wData: "school",
                name:name,
                shortName:shortName,
                email:email,
                phone:phonenumber
            },
            success: function (msg) {
                console.log(msg)
                msg = JSON.parse(msg)
                if(msg.success){
                    alertify.notify('Sikeres mentés!', 'success', 5)
                    panel = 1
                    $(".installPage")[0].innerHTML = 3 
                    $(".backTo")[0].onclick=function(){backToPanel(1)}
                    
                    $(".school").fadeOut()
                    $(".adminpanel").show("slide", { direction: "left" }, 1000)
                    $(".progress-bar")[0].style.width="100%"

                }else{
                                //2002 - Bad IP
                                //1049 - Bad DB
                                //1045 - Bad Username/password
                    if(msg.response=="1045"){
                        alertify.notify("Sikertelen kapcsolódás. ('"+dbUser+"'@'"+(dbName||'localhost')+"')", 'error', 5)
                    }else if(msg.response=="1049"){
                        alertify.notify("Nem létezik a(z) "+dbName+" adatbázis!", 'error', 5)
                    }
                    else if(msg.response=="2002"){
                        alertify.notify("A(z) "+ip+" célcím elutasította a kapcsolódást, vagy nem lehet létrehozni azt!", 'error', 5)
                    }
                }
            }
        })
    }
}
$(".loader-wrapper").fadeOut("slow")
$("header").css("display","flex")


const backToPanel = id =>{
    $(".installPage")[0].innerHTML = id+1
    panel = id
    console.log("v")
    if(id==0){
        $(".database").fadeIn()
        $(".school").fadeOut()
    }else if(id==1){
        $(".school").fadeIn()
        $(".adminpanel").fadeOut()
    }

}