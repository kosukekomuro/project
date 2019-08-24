/**
*入力値が空欄の場合、エラーメッセージを出力
*@constructor
*@param {String} input 入力値
*@param {String} errorMessage 出力するエラーメッセージ
*@param {String} addLocation エラーメッセージの追加場所を指定 
*@return {Boolean}
*/
const checkInput = (input, errorMessage, addLocation) =>{
  if(input.length == 0){

    addErrorMessage(errorMessage, addLocation);
    return true
  }
  return false
};

/**
*再確認パスワードの入力チェックを行う関数
*@constructor
*@param {String}  confirmPass 再確認パスワード
*@param {String}  password パスワード
*@param {String} errorMessage 出力するエラーメッセージ
*@param {String} addLocation エラーメッセージの追加場所を指定 
*@return {Boolean}
*/
const checkInputConfirmPassword = (confirmPass, password, errorMessage, addLocation) =>{
  // ユーザー未入力時
  if(password != confirmPass){

    addErrorMessage(errorMessage, addLocation);
    return true
  }
  return false
};

/**
*エラーメッセージを追加する
*@constructor
*@param {String} errorMessage 出力するエラーメッセージ
*@param {String} addLocation エラーメッセージの追加場所を指定 
*/
const addErrorMessage = (errorMessage, addLocation) => {
  const html = `<p class="error-message">
                  ${errorMessage}
                </p>`

  $(addLocation).after(html);
}
