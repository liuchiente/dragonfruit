<!DOCTYPE html><html><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover, user-scalable=no"><title>分享 LINE 數位版名片</title><meta name="description" content="請開啟本連結並按一下「分享好友」來分享給好友或群組。"><meta property="fb:app_id" content="2133031763635285"><meta property="og:description" content="請開啟本連結並按一下「分享好友」來分享給好友或群組。"><meta property="og:locale" content="zh_TW"><meta property="og:site_name" content="LINE 數位版名片"><meta property="og:title" content="分享 LINE 數位版名片"><meta property="og:type" content="website"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/css/bootstrap.min.css"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4/css/font-awesome.min.css"><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&amp;display=swap"><style>[v-cloak] {
  display: none;
}

body, .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
  font-family: "Noto Sans TC", sans-serif;
}</style></head><body>@verbatim<script>(function () {
  const url = new URL(location)
  const livereload = new URL('https://cdn.jsdelivr.net/npm/livereload-js@3/dist/livereload.js?snipver=1')
  livereload.searchParams.set('host', url.hostname)
  if (url.protocol === 'https:') {
    livereload.searchParams.set('port', url.port || 443)
    livereload.searchParams.set('https', 1)
  } else {
    livereload.searchParams.set('port', url.port || 80)
  }
  document.write(`<script src="${livereload.href}"></` + 'script>')
})()</script>@endverbatim<script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/crypto-js@3/crypto-js.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/js-base64@3/base64.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/json5@2/dist/index.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/lodash@4/lodash.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/pako@2/dist/pako.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/papaparse@5/papaparse.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/popper.js@1/dist/umd/popper.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/qs@6/dist/qs.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/vue-i18n@8/dist/vue-i18n.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/js/bootstrap.min.js"></script>@verbatim<script src="https://cc.fruit/js/common.js?cachebust=1696238313443"></script>@endverbatim<script crossorigin="anonymous" src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script><script>(async () => {
  await liff.init({ liffId: '' })
  if (window.getSearchParam('liff.state')) return
  localStorage.setItem('swalFire', JSON5.stringify({
    icon: 'warning',
    title: '請更換名片網址',
    text: '你之前使用的名片網址即將失效，請在本頁面複製新名片網址。',
  }))
  const url = `https://liff.line.me/1661414135-95aMGZzm/share.html${new URL(location).search}`
  if (liff.isInClient()) liff.openWindow({ url })
  else location.href = url
})()</script></body></html>