let dragSrcEl = null;
let taskOrder = null;

Pace.on('done', function(){
  $('.taskal-container').fadeIn();
});

const handleDragStart = e => {
  dragSrcEl = e.currentTarget;
  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text', dragSrcEl.outerHTML);
  // タスクのオーダー順を取得
  taskOrder = dragSrcEl.getElementsByClassName('task_info')[0].getAttribute("task_order");
}

const handleDragOver = e => {
  // デフォルトのアクションを防ぐ 
  e.preventDefault();

  // 現在乗っているhtml要素に対し、overクラスを追加
  e.currentTarget.classList.add('over');
  e.dataTransfer.dropEffect = 'move'; 
  return false;
}

const handleDragEnter = () => {
}

const handleDragLeave = e => {
  e.currentTarget.classList.remove('over'); 
}

const handleDrop = e => {
  e.stopPropagation(); 

  // 自分の要素でない時は実行しない。
  if (dragSrcEl != e.currentTarget) {
    // ドロップする場所の要素を取得
    let dropSrcEl = e.currentTarget;

    // ドロップした要素を追加
    var dropHTML = e.dataTransfer.getData('text');
    dropSrcEl.insertAdjacentHTML('beforebegin', dropHTML);

    const dropTaskOrder = dropSrcEl.getElementsByClassName('task_info')[0].getAttribute("task_order");
    let min;
    let max;
    let overwrite_element;
    let data;

    // ドラッグしている要素のドロップ場所の上下ごとに条件を設定
    if(taskOrder < dropTaskOrder){
      min = taskOrder;
      max = dropTaskOrder - 1;
      overwrite_element = dragSrcEl.nextElementSibling;
    }else{
      min = dropTaskOrder;
      max = taskOrder;
      overwrite_element = dropSrcEl.previousSibling;
    }

    // task_orderの上書き
    for (let order = min; order <= max; order++) {
      // 値が min から max まで実行される
      overwrite_element.getElementsByClassName('task_info')[0].setAttribute("task_order", order);
      data = {task_id: overwrite_element.getElementsByClassName('task_info')[0].value ,task_order: overwrite_element.getElementsByClassName('task_info')[0].getAttribute("task_order")};

      $.ajax({
        url: "../../models/tasks/update_task_order.php",
        type: "POST",
        data: data,
        dataType: 'json',
      })
      .done(function(data){

      })
      .fail(function(){
        alert('通信に失敗しました。再度読み込んでください');
      });

      // 次のリスト要素にシフト
      overwrite_element = overwrite_element.nextElementSibling;
    }

    // 元の要素を削除
    e.currentTarget.parentNode.removeChild(dragSrcEl);
    
    const dropElem = dropSrcEl.previousSibling;
    addDnDHandlers(dropElem);
  }
  e.currentTarget.classList.remove('over');
  return false;
}

const handleDragEnd = e => {
  e.currentTarget.classList.remove('over');
}

const addDnDHandlers = elem => {
  // ドラッグ開始時に実行
  elem.addEventListener('dragstart', handleDragStart, false);
  // ドラッグしている要素がドロップ領域に入った時
  elem.addEventListener('dragenter', handleDragEnter, false)
  //ドラッッグしている要素がドロップ領域に入った時。 
  elem.addEventListener('dragover', handleDragOver, false);
  //ドラッッグしている要素がドロップ領域から出た時。
  elem.addEventListener('dragleave', handleDragLeave, false);
  //ドラッッグしている要素がドロップ領域にドロップした時。
  elem.addEventListener('drop', handleDrop, false);
  // ドラッグ終了時
  elem.addEventListener('dragend', handleDragEnd, false);
}

// $(document).ready(function(){ と同様の動作をおこなう
$(function(){

  // 一致する要素全てをNodelistとして取得する
  // ドラッヅアンドドロップに関わる記事
  // https://app.codegrid.net/entry/dnd-api-1
  const cols = document.querySelectorAll(".task-main__task-ul .task-list");
  [].forEach.call(cols, addDnDHandlers);

  // ポップアップ画面の表示
  $(".make-task-details").on("click", () => {
    $(".task-main").css("display", "none");
    $(".detail_task").css("display", "block");
    $(".taskal-container").css("background-color", "rgba(0,0,0,0.4)");
  });

  // キャンセルボタンの押下
  $(".add-detail-task-form__cancel-btn").on("click", () => {
    $(".task-main").css("display", "block");
    $(".detail_task").removeAttr('style');
    $(".taskal-container").removeAttr('style');
    $(".taskal-container").css("display", "block");
    $(".error-message").remove();
  });

  // タスク変更画面の表示
  $(".one-task__update-btn").on("click", e => {

    const task = $(e.currentTarget);
    const taskId = task.attr('task_id');
    data = {task_id: taskId};

      $.ajax({
        url: "../../models/tasks/select_task.php",
        type: "POST",
        data: data,
        dataType: 'json',
      })
      .done(function(data){
        // 日付のフォーマットを変更
        let dueDate = null;

        if(data.due_date != null){
          dueDate = data.due_date.replace(" ", "T");
        };

        // フォームにタスク詳細を設定
        $('.update-task-form__task-name').val(data.task_name);
        $('.update-task-form__task-discription').val(data.task_discription);
        $('.update-task-form__task-due-date').val(dueDate);
        $('.update-task-form__task-id').val(taskId);

        // ポップアップ画面の表示
        $(".task-main").css("display", "none");
        $(".update_task").css("display", "block");
        $(".taskal-container").css("background-color", "rgba(0,0,0,0.4)");
      })
      .fail(function(){
        alert('通信に失敗しました。再度読み込んでください');
      });
  });

  // キャンセルボタンの押下
  $(".update-task-form__cancel-btn").on("click", () => {
    $(".task-main").css("display", "block");
    $(".update_task").removeAttr('style');
    $(".taskal-container").removeAttr('style');
    $(".taskal-container").css("display", "block");
    document.update_task_form.reset();
    $(".error-message").remove();
  });

  // ログイン画面のエラーチェック
  // ログインボタン押下時に発火
  $('.login-form').on('submit', (e) =>{

    $(".error-message").remove();

    // 入力されたユーザー名, ユーザパスワードの取得
    const userName = document.login_form.user_name.value;
    const userPassword = document.login_form.user_password.value
    let loginFlug = true;

    if(
      checkInput(userName, errorMessage001, '.login-form__name')
    ){
      e.preventDefault();
      loginFlug = false;
    };

    if(
      checkInput(userPassword, errorMessage002, '.login-form__password')
    ){
      e.preventDefault();
      loginFlug = false;
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

    // 非同期処理は同期処理と同時進行で進むため、非同期処理に入る前に一旦
    // デフォルトの処理を止める必要あり。
    // 非同期処理後に再開する
    e.preventDefault();

    if(loginFlug){

      const _this = e.currentTarget;
      
      // ユーザー認証apiに送信
      // 送信データの作成
      data = {user_name: userName, user_password: userPassword};

      $.ajax({
        url: "api/v1/authenticate.php",
        type: "POST",
        data: data,
        dataType: 'json'
      })
      .done(function(data){
        console.log(data);

        console.log(data.result.code);
        
        // __proto__はオブジェクトが作られると裏で作られるObject.prototype
        // 参考記事
        // https://qiita.com/howdy39/items/35729490b024ca295d6c
        console.log(data.__proto__ == Object.prototype);

        // 一致するユーザーが存在しない場合のエラー
        if(data.result.code == 3){
          console.log("認証エラー");
          $(".error-message").remove();
          addErrorMessage(errorMessage005, '.login-form__name');
        };

        // 正常な場合
        if(data.result.code == 1){
          // デフィルトの送信処理を再開する
          _this.submit();
        };
      })
      .fail(function(jqXHR, textStatus, errorThrown ){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
        // エラーメッセージを表示する
        console.log(jqXHR.responseText);
      });
    };
  });

  // ユーザー登録画面のチェックを行う。
  $('.sign-up-form').on('submit', (e) =>{
    
    $(".error-message").remove();

    // ユーザー名チェック
    if(
      checkInput(document.sign_up_form.user_name.value, errorMessage001, '.sign-up-form__name')
    ){
      e.preventDefault();
    };

    // パスワードチェック
    if(checkInput(document.sign_up_form.user_password.value, errorMessage002, '.sign-up-form__password')
    ){
      e.preventDefault();
    };

    // パスワードの再確認チェック
    if(checkInputConfirmPassword(document.sign_up_form.user_confirm_password.value, document.sign_up_form.user_password.value, errorMessage003, '.sign-up-form__confirm-password')
    ){
      e.preventDefault();
    };
  });


  // タスク一覧画面にて、タスク追加時の入力チェックを行う
  $('.task-main__add-task-form').on('submit', (e) =>{
    
    $(".error-message").remove();

    // タスクの入力値チェック
    if(checkInput($(".task-name").val(), errorMessage004, '.task-main__add-task-form')
    ){
      e.preventDefault();
    };
  });

  //  タスクの詳細追加画面にて、タスク追加時に入力チェックを行う。
  $('.add-detail-task-form').on('submit', (e) =>{
    
    $(".error-message").remove();
    // タスクの入力値チェック
    if(checkInput($(".add-detail-task-form__task-name").val(), errorMessage004, '.add-detail-task-form__task-name')
    ){
      e.preventDefault();
    };
  });

  // タスク更新画面にて、タスクの更新時にに入力チェックを行う
  $('.update-task-form').on('submit', (e) =>{
    
    $(".error-message").remove();
    // タスクの入力値チェック
    if(checkInput($(".update-task-form__task-name").val(), errorMessage004, '.update-task-form__task-name')
    ){
      e.preventDefault();
    };
  });
});




