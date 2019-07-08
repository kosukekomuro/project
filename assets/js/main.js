let dragSrcEl = null;
let taskOrder = null;

  const handleDragStart = e => {
    dragSrcEl = e.currentTarget;
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text', dragSrcEl.outerHTML);
    // タスクのオーダー順を取得
    taskOrder = dragSrcEl.getElementsByClassName('task_info')[0].getAttribute("task_order");
    // 指定した要素にクラス名を追加する
  }

  const handleDragOver = e => {
    // デフォルトのアクションを防ぐ 
    // Todoなぜifがついている？
    // if (e.preventDefault) {
    e.preventDefault();
    // }

    // デフォルトのアクションを防ぐ、現在乗っているhtml要素に対し、overクラスを追加
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
    // if (e.stopPropagation) {
    e.stopPropagation(); 
    // }

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

      // ドラッグしている要素のドロップ場所の上下ごとに条件を設定
      if(taskOrder < dropTaskOrder){
        min = taskOrder;
        max = dropTaskOrder;
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

  $(document).ready( function(){

    // 一致する要素全てをNodelistとして取得する
    // ドラッヅアンドドロップに関わる記事
    // https://app.codegrid.net/entry/dnd-api-1
    var cols = document.querySelectorAll('.task-main__task-ul .task-list');
    [].forEach.call(cols, addDnDHandlers);
  });

