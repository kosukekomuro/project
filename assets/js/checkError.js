window.onload = function() {

  // 入力チェックを行う。
  $('.login-form').on('submit', (e) =>{
    let loginCheckFlag = true;

    $(".error-message").remove();

    // ユーザー名が空欄の時
    if(document.login_form.user_name.value.length == 0){

      let html = `<p class="error-message">
                    ユーザー名が入力されていません
                  </p>`
      
      $('.login-form__name').after(html);
      loginCheckFlag = false;
      e.preventDefault();
    };

    // パスワードが空欄の時
    if(document.login_form.user_password.value.length == 0){
      let html = `<p class="error-message">
                    パスワードが入力されていません
                  </p>`

      $('.login-form__password').after(html);
      loginCheckFlag = false;
      e.preventDefault();
    };

    // Todo ログイン判定を非同期う
    // if(loginCheckFlag){
    //   data = {user_name: document.login_form.user_name.value,
    //           user_pass: document.login_form.user_password.value
    //         };

    //   $.ajax({
    //     url: "views/users/check_login.php",
    //     type: "POST",
    //     data: data,
    //     dataType: 'json',
    //   })
    //   .done(function(data){
    //     console.log("成功");
    //     console.log(data);
    //   })
    //   .fail(function(XMLHttpRequest, textStatus, errorThrown, data){
    //     alert('通信に失敗しました。再度読み込んでください');
    //     console.log("ajax通信に失敗しました");
    //     console.log("XMLHttpRequest : " + XMLHttpRequest.status);
    //     console.log("textStatus     : " + textStatus);
    //     console.log("errorThrown    : " + errorThrown.message);
    //     console.log(data);
    //   });
    // };
  });
};
