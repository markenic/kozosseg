const loginVar = () => {
  let usr = $("#usr")[0].value;
  let pass = $("#pass")[0].value;
  let format = /[ `!@#$%^&*()+\=\[\]{};':"\\|,<>\/?~]/;
  $("#loginBtn")[0].innerHTML= '<div class="dot-carousel"></div>';
  $("#loginBtn")[0].disabled=true;
  if (format.test(usr) == false && format.test(pass) == false) {
    grecaptcha.ready(function() {
      grecaptcha.execute('6LcVGsMZAAAAAGd1lp4blTRC1NY-QslUGl6x0nZm', {action: 'login'}).then(function(token) {

        $.ajax({
          url: 'login.php',
          type: 'POST',
          data: {
            usr: usr,
            pass: pass,
            token:token
          },
          success: function (msg) {
          console.log(msg)
            msg = JSON.parse(msg);
            if (msg.success) {
              location.reload();
            } else {
              if (msg.response == "Bad PW"){
                $("#alert")[0].setAttribute("class", "alert alert-danger");
                $("#alert")[0].innerHTML = "Hibás felhasználónév vagy jelszó!";
                $("#loginBtn")[0].innerHTML= 'Belépés';
                $("#loginBtn")[0].disabled=false;
              }else{
                console.log(msg.response);
                $("#loginBtn")[0].innerHTML= 'Belépés';
                $("#loginBtn")[0].disabled=false;
              }

            }
          }
        });
      });
    });

  } else {
    $("#alert")[0].setAttribute("class", "alert alert-danger");
    $("#alert")[0].innerHTML = "Valami baj van! Nem tartalmazhatnak speciális karaktert az adatok!";
  }
};
const checkForValid = (that) =>{
  let text = that.value;
  let id = that.id;
  let requirements = {
    'regUsr':{
      length:6,
      text:'A felhasználónevednek legalább 6 karakterből kell állnia és nem használhatsz speciális karaktereket! (Pl. felhasznalo1)',
    },
    'regPass':{
      length:6,
      text:'A jelszavadnak legalább 6 karakterből kell állnia!'
    },
    'regEmail':{
      length:3,
      text:'Valós email címet adj meg!',
      special:'@'
    },
    'regFirstName':{
      length:3,
      text:'Valós vezetékneved add meg és nem használhatsz speciális karaktereket!'
    },
    'regLastName':{
      length:3,
      text:'Valós keresztneved add meg és nem használhatsz speciális karaktereket!'
    }
  }

  if(text.length<requirements[id].length){
    $(that).addClass('is-invalid');
    if($(that).hasClass('is-valid')){
      $(that).removeClass('is-valid');
    }
    if(that.id == "regFirstName" || that.id=="regLastName"){
      if($('#errorregName')[0].innerHTML==''){
        $('#errorregName')[0].innerHTML=requirements[id].text;
        $('#errorregName').removeClass("d-none");
      } 
    }else{
      if($('#error'+id)[0].innerHTML==''){
        $('#error'+id)[0].innerHTML=requirements[id].text;
        $('#error'+id).removeClass("d-none");
      } 
    }
  }else {
    $(that).removeClass('is-invalid');
    $(that).addClass('is-valid');
    if(that.id == "regFirstName" || that.id=="regLastName"){
      $('#errorregName')[0].innerHTML='';
      $('#errorregName').addClass("d-none");
    }else{
      $('#error'+id)[0].innerHTML='';
      $('#error'+id).addClass("d-none");
    }

  }
  if(requirements[id].special){
    if(!text.includes(requirements[id].special)){
      $(that).addClass('is-invalid');
      if($(that).hasClass('is-valid')){
        $(that).removeClass('is-valid');
      }

      if($('#error'+id)[0].innerHTML==''){
        $('#error'+id)[0].innerHTML=requirements[id].text;
      }
    }else{
      $(that).removeClass('is-invalid');
      $('#error'+id)[0].innerHTML='';
      $(that).addClass('is-valid');   
    }
    
  }


};
const changeSelect = (select) =>{
  if(select.options[$(".class")[0].selectedIndex].innerHTML=='Tanárok'){
    $('.teacherCode').removeClass('d-none');
  }else{
    $('.teacherCode').addClass('d-none')
  }
};

const regVar = () => {
  let usr = $("#regUsr")[0].value;
  let pass = $("#regPass")[0].value;
  let email = $("#regEmail")[0].value;
  let name = $("#regFirstName")[0].value+" "+$("#regLastName")[0].value;
  let teacherCode = $("#regTeacherCode")[0].value; 
  
  if($(".class") && $(".class")[0].options[$(".class")[0].selectedIndex].value!="" && $(".class")[0].options[$(".class")[0].selectedIndex].value!=" "){
    classid = $(".class")[0].options[$(".class")[0].selectedIndex].value;
  }else{
    classid = 1;
  }
  $("#regBtn")[0].innerHTML= '<div class="dot-carousel"></div>';
  $("#regBtn")[0].disabled=true;


  if (usr.length >= 6 && pass.length >= 6 && email && name) {
    let format = /[ `!@#$%^&*()+\=\[\]{};':"\\|,<>\/?~]/;
    if (format.test(usr) == false && format.test(pass) == false) {
      if(format.test(email)==true){
        if($("#regUsr").hasClass("is-valid")&&$("#regPass").hasClass("is-valid")&&$("#regEmail").hasClass("is-valid")&&$("#regFirstName").hasClass("is-valid")&&$("#regLastName").hasClass("is-valid")){
          console.log("sdfdfsdf");
          grecaptcha.ready(function() {
            grecaptcha.execute('6LcVGsMZAAAAAGd1lp4blTRC1NY-QslUGl6x0nZm', {action: 'register'}).then(function(token) {
              $.ajax({
                url: 'register.php',
                type: 'POST',
                data: {
                  usr: usr,
                  pass: pass,
                  name: name,
                  email: email,
                  classid:classid,
                  teacherCode: teacherCode,
                  token:token
                },
                success: function (msg) {
                  console.log(msg);
                  msg = JSON.parse(msg);
                  if (msg.success) {
                    $("#regAlert")[0].setAttribute("class", "alert alert-success");
                    $("#regAlert")[0].innerHTML = "Sikeres regisztráció!";
                  } else {
                    if (msg.response == "Bad User") {
                      $("#regAlert")[0].setAttribute("class", "alert alert-danger");
                      $("#regAlert")[0].innerHTML = "Foglalt felhasználónév!";
                    } else if (msg.response == "Bad Email") {
                      $("#regAlert")[0].setAttribute("class", "alert alert-danger");
                      $("#regAlert")[0].innerHTML = "Foglalt Email cím!";
                    } else if (msg.response == "bad teacher code") {
                      $("#regAlert")[0].setAttribute("class", "alert alert-danger");
                      $("#regAlert")[0].innerHTML = "Hibás tanári kód!";               
                    }else{
                      console.log(msg.response);
                    }
                  }
                }
              });
            });
          });
        }
      }else{
        $("#regAlert")[0].setAttribute("class", "alert alert-danger");
        $("#regAlert")[0].innerHTML = "Valami baj van! Valós email címet adj meg!";
      }

    } else {
      $("#regAlert")[0].setAttribute("class", "alert alert-danger");
      $("#regAlert")[0].innerHTML = "Valami baj van! Nem tartalmazhatnak speciális karaktert az adatok!";
    }

  } else {
    $("#regAlert")[0].setAttribute("class", "alert alert-danger");
    $("#regAlert")[0].innerHTML = "Valami baj van! A felhasználónevednek és jelszavadnak minimum 6 karakterből kell állnia!";
  }

};

const changePass = () => {
  let oldPass = $("#oldpass")[0].value;
  let newPass = $("#newpass")[0].value;
  let format = /[ `!@#$%^&*()+\=\[\]{};':"\\|,<>\/?~]/;
  if (format.test(oldPass) == false && format.test(newPass) == false) {
    if(pass.length >= 6){
      $.ajax({
        url: 'assets/changePass.php',
        type: 'POST',
        data: {
          oldpass: oldPass,
          newpass: newPass

        },
        success: function (msg) {
          msg = JSON.parse(msg);
          if (msg.success) {
            alertify.notify('Sikeres módosítás!', 'success', 3);
          } else {
            if (msg.response == "bad pass") {
              alertify.notify('Hibás jelszót adtál meg!', 'error', 3);
            } else {
              alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 3);
              console.log("%c" + msg.response, "color:red");
            }
          }
        }
      });
    }else{
      alertify.notify('Hiba! A jelszavadnak legalább 6 karakterből kell állnia!', 'error', 3);
    }
  } else {
    alertify.notify('Valami baj van! Nem tartalmazhatnak speciális karaktert az adatok!', 'error', 6);
  }
};
const changeMail = () => {
  let email = $("#email")[0].value;
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if(re.test(email)){
    $.ajax({
      url: 'assets/changeEmail.php',
      type: 'POST',
      data: {
        email: email,
      },
      success: function (msg) {
        console.log(msg);
        msg = JSON.parse(msg);
        if (msg.success) {
          alertify.notify('Sikeres módosítás!', 'success', 3);
        } else {
          alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 3);
          console.log("%c" + msg.response, "color:red");
        }
      }
    });
  }
};