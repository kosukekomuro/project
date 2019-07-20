/**
*ユーザー名の入力チェックを行う関数
*@constructor
*@param {String} userName ユーザー名
*/
const checkInputUserName = userName =>{
  // ユーザー未入力時
  if(userName.length == 0){
    return true
  }

  return false
};

/**
*パスワードの入力チェックを行う関数
*@constructor
*@param {String} password パスワード
*/
const checkInputPassword = password =>{
  // ユーザー未入力時
  if(password.length == 0){
    return true
  }

  return false
};

/**
*再確認パスワードの入力チェックを行う関数
*@constructor
*@param {String}  confirmPass 再確認パスワード
*@param {String}  password パスワード
*/
const checkInputConfirmPassword = (confirmPass, password) =>{
  // ユーザー未入力時
  if(password != confirmPass){
    return true
  }

  return false
};

window.onload = () => {
  // 入力チェックを行う。
  $('.login-form').on('submit', (e) =>{

    $(".error-message").remove();

    // ユーザー名が空欄の時
    if(checkInputUserName(document.login_form.user_name.value)){
      let html = `<p class="error-message">
                    ユーザー名が入力されていません
                  </p>`
      
      $('.login-form__name').after(html);
      e.preventDefault();
    };

    // パスワードが空欄の時
    if(checkInputPassword(document.login_form.user_password.value)){
      let html = `<p class="error-message">
                    パスワードが入力されていません
                  </p>`

      $('.login-form__password').after(html);
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

  // 入力チェックを行う。
  $('.sign-up-form').on('submit', (e) =>{
    
    $(".error-message").remove();

    // ユーザー名チェック
    if(checkInputUserName(document.sign_up_form.user_name.value)){
      let html = `<p class="error-message">
                    ユーザー名が入力されていません
                  </p>`
      
      $('.sign-up-form__name').after(html);
      e.preventDefault();
    };

    // パスワードチェック
    if(checkInputPassword(document.sign_up_form.user_password.value)){
      let html = `<p class="error-message">
                    パスワードが入力されていません
                  </p>`

      $('.sign-up-form__password').after(html);
      e.preventDefault();
    };

    // パスワードの再確認チェック
    if(checkInputConfirmPassword(document.sign_up_form.user_confirm_password.value, document.sign_up_form.user_password.value)){
      let html = `<p class="error-message">
                    パスワードと再確認パスワードが一致しません
                  </p>`

      $('.sign-up-form__confirm-password').after(html);
      e.preventDefault();
    };
  });
};
