var dragSrcEl = null;

  const handleDragStart = e => {
    dragSrcEl = e.currentTarget;
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', e.currentTarget.outerHTML);
    //  指定した要素にクラスメイをつい以下する
    e.currentTarget.classList.add('dragElem');
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

  function handleDrop(e) {
    // if (e.stopPropagation) {
    e.stopPropagation(); 
    // }

    // 自分の要素でない時は実行しない。
    if (dragSrcEl != this) {
      this.parentNode.removeChild(dragSrcEl);
      var dropHTML = e.dataTransfer.getData('text/html');
      console.log(dropHTML);
      this.insertAdjacentHTML('beforebegin', dropHTML);

      // 初期化
      var dropElem = this.previousSibling;
      addDnDHandlers(dropElem);
    }
    this.classList.remove('over');
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

