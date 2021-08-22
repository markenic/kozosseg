$(function() {
    loadEveryThing()
});
let places = [],
  placesCopy = [],
  resultPlaces = [],
  placeTypes = [],
  classes = [],
  successLoad = false,
  loaded = 0,
  lang;

let loadEveryThing = () => {

    $.ajax({ //language
      url: 'assets/getText.php',
      type: 'POST',
      data: {
        get: true
      },
      success: function (msg) {
        msg = JSON.parse(msg);
        if (msg.success) {
          lang = msg.response
        } else {

        }
      },
      error: function (textStatus, err) {
        if (err == "error") {
          alertify.notify(lang.errDevelop, 'error', 5);
          console.log("%c" + err, "color:red");
        }
      }
    });
    $.ajax({ //Teachers
        url: 'assets/getDatas.php',
        type: 'POST',
        data: {
          wData: "teachers"
        },
        success: function (msg) {
          msg = JSON.parse(msg);
          if (msg.success) {
            teachers = msg.response;
            loaded += 1; 
          } else {
            if (msg.response) {
              console.log("Error: " + msg.response);
            } else {
              console.log(lang.errDevelop);
            }
          }
        },
        error: function (textStatus, err) {
          if (err == "error") {
            alertify.notify(lang.errDevelop, 'error', 5);
            console.log("%c" + err, "color:red");
          }
        }
      });
    $.ajax({ //Places
      url: 'assets/getDatas.php',
      type: 'POST',
      data: {
        wData: "places"
      },
      success: function (msg) {
        msg = JSON.parse(msg);
        if (msg.success) {
          places = msg.response;
          loaded += 1; 
        } else {
          if (msg.response) {
            console.log("Error: " + msg.response);
          } else {
            console.log(lang.errDevelop);
          }
        }
      },
      error: function (textStatus, err) {
        if (err == "error") {
          alertify.notify(lang.errDevelop, 'error', 5);
          console.log("%c" + err, "color:red");
        }
      }
    });
    $.ajax({ //Places
        url: 'assets/getDatas.php',
        type: 'POST',
        data: {
          wData: "userPlaces"
        },
        success: function (msg) {
          msg = JSON.parse(msg);
          if (msg.success) {
            resultPlaces = msg.response;
            loaded += 1; 
          } else {
            if (msg.response) {
              console.log("Error: " + msg.response);
            } else {
              console.log(lang.errDevelop);
            }
          }
        },
        error: function (textStatus, err) {
          if (err == "error") {
            alertify.notify(lang.errDevelop, 'error', 5);
            console.log("%c" + err, "color:red");
          }
        }
      });
    $.ajax({ //Classes
      url: 'assets/getDatas.php',
      type: 'POST',
      data: {
        wData: "classes"
      },
      success: function (msg) {
        msg = JSON.parse(msg);
        if (msg.success) {
          classes = msg.response;
          loaded += 1; 
        } else {
          if (msg.response) {
            console.log("Error: " + msg.response);
          } else {
            console.log(lang.errDevelop);
          }
        }
      },
      error: function (textStatus, err) {
        if (err == "error") {
          alertify.notify(lang.errDevelop, 'error', 5);
          console.log("%c" + err, "color:red");
        }
      }
    });
    let int = setInterval(function(){
        if(loaded>=2){
            insertPlaces()
            clearInterval(int)
        }
    }, 1000);

  };

  const insertPlaces = () =>{
    for (let i = 0; i < resultPlaces.length; i++) {
            if (resultPlaces.length > 0) {
              makeCard(resultPlaces[i].id, places[resultPlaces[i].id].name+" - "+resultPlaces[i].hour+" órában");
            }
    }

  }
  const makeCard = (id, name) => {
    let li = document.createElement("li");
    $(".userPlaces")[0].appendChild(li);
    li.setAttribute("class", "list-group-item d-flex justify-content-between placeCard");
    li.style.marginBottom = "10px";
    li.style.borderLeft = "2px solid #5BC0DE";
    let text = document.createElement("p");
    li.setAttribute("name", name);
    text.innerHTML = name;
    text.setAttribute("class", "p-0 m-0 flex-grow-1");
    li.appendChild(text);
    li.id = id+name
    if (id != null) {
  
      icon = document.createElement("a");
      icon.innerHTML = '<i class="fas fa-trash-alt fa-lg"></i>';
      icon.setAttribute("class", "exit text-warning float-right");
      icon.onclick = function () {
        removePlace(id,li.id)
      };
      li.appendChild(icon);
      icon.style.marginLeft = "10px";
  
    }
  
    return li;
  };
  
const removePlace = (id,liid) => {
  alertify.confirm('Törlés', 'Biztosan törölni szeretnéd ezt a helyszínt?',
    function () {

        $.ajax({
          url: 'assets/changeDatas.php',
          type: 'POST',
          data: {
            wData: "removePlace",
            id: id

          },
          success: function (msg) {
            msg = JSON.parse(msg);
            $(".save")[0].innerHTML= 'Mentés';
            $(".save")[0].disabled=false;
            if (msg.success) {
              alertify.notify('Sikeres törlés!', 'success',5);

              $(document.getElementById(liid)).remove();
              if ($('.cards').is(':empty')) {
                makeCard(null, "noPlace").children[0].innerHTML = "Nincs egyetlen választott helyszíned sem! <i class='fas fa-sad-tear fa-lg'></i>";
                //$(".paperbtn")[0].disabled = true;
              }

            } else {
              alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 5);
              console.log("%c" + msg.response, "color:red");
            }
            //loadUsers(msg);
          }
        });
    },
    function () {});
}

const saveDatas = () =>{
  if($("#email")[0].value!=""){
    $(".save")[0].innerHTML= '<div class="dot-carousel"></div>';
    $(".save")[0].disabled=true;
    $.ajax({
      url: 'assets/changeEmail.php',
      type: 'POST',
      data: {
        email:$("#email")[0].value,
  
      },
      success: function (msg) {
        $(".save")[0].innerHTML= 'Mentés';
        $(".save")[0].disabled=false;
        msg = JSON.parse(msg);
        if (msg.success) {
          alertify.notify('Sikeres email módosítás!', 'success',5);
  
        } else {
          if(msg.response=="no need to change"){
            return false;
          }
          alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 5);
          console.log("%c" + msg.response, "color:red");
        }
      }
    });
  }

  if($("#pass1")[0].value!=""){
    if($("#pass1")[0].value==$("#pass2")[0].value){
      alertify.notify('A két jelszó nem egyezhet meg!', 'error',5)
      return false
    }
    $(".save")[0].innerHTML= '<div class="dot-carousel"></div>';
    $(".save")[0].disabled=true;
    $.ajax({
      url: 'assets/changePass.php',
      type: 'POST',
      data: {
        oldpass:$("#pass1")[0].value,
        newpass:$("#pass2")[0].value
      },
      success: function (msg) {
        console.log(msg)
        $(".save")[0].innerHTML= 'Mentés';
        $(".save")[0].disabled=false;
        msg = JSON.parse(msg);
        if (msg.success) {
          alertify.notify('Sikeres jelszó módosítás!', 'success',5);
  
        } else {
          if(msg.response=="bad pass"){
            alertify.notify('Hiba! Az eredeti jelszó nem megfelelő!', 'error',5);
          }else if(msg.response=="low char"){
            alertify.notify('Hiba! A jelszavadnak legalább 6 karakterből kell állnia!', 'error',5);

          }else{
            alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 5);
            console.log("%c" + msg.response, "color:red");         
          }
        }
      }
    });
  }

}
