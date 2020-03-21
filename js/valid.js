const loginVar = () =>{
    let usr = $("#usr")[0].value;
    let pass = $("#pass")[0].value;
  
    $.ajax({
      url: 'login.php',
      type: 'POST',
      data: {
        usr:usr,
        pass:pass
  
      },
      success: function(msg) {
        if(msg.success){
          location.reload();
        }else{
          if(msg.response=="Bad PW")
          $("#alert")[0].setAttribute("class","alert alert-danger");
          $("#alert")[0].innerHTML="Hibás felhasználónév vagy jelszó!";
        }
      }               
    });
  };
  
  const regVar = () =>{
    let usr = $("#regUsr")[0].value;
    let pass = $("#regPass")[0].value;
    let email = $("#regEmail")[0].value;
    let name = $("#regName")[0].value;
  
    if(usr.length>=6&&pass.length>=6&&email&&name){
      $.ajax({
        url: 'register.php',
        type: 'POST',
        data: {
          usr:usr,
          pass:pass,
          name:name,
          email:email
    
        },
        success: function(msg) {
          msg = JSON.parse(msg);
          if(msg.success){
            $("#regAlert")[0].setAttribute("class","alert alert-success");
            $("#regAlert")[0].innerHTML="Sikeres regisztráció!";
          }else{
            if(msg.response=="Bad User"){
              $("#regAlert")[0].setAttribute("class","alert alert-danger");
              $("#regAlert")[0].innerHTML="Foglalt felhasználónév!";
            }else if(msg.response=="Bad Email"){
              $("#regAlert")[0].setAttribute("class","alert alert-danger");
              $("#regAlert")[0].innerHTML="Foglalt Email cím!";            
            }
          }
        }               
      });
    }else{
      $("#regAlert")[0].setAttribute("class","alert alert-danger");
      $("#regAlert")[0].innerHTML="Valami baj van! A felhasználónevednek és jelszavadnak minimum 6 karakterből kell állnia!";
    }
  
  };