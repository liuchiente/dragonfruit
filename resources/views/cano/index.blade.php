<!DOCTYPE html><html><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover, user-scalable=no"><title>免費樣版列表</title><meta name="description" content="點此連結來製作自己的 LINE 數位版名片吧！"><meta property="fb:app_id" content="2133031763635285"><meta property="og:description" content="點此連結來製作自己的 LINE 數位版名片吧！"><meta property="og:locale" content="zh_TW"><meta property="og:site_name" content="LINE 數位版名片"><meta property="og:title" content="免費樣版列表"><meta property="og:type" content="website"><meta property="og:image:height" content="640"><meta property="og:image:width" content="1280"><meta property="og:image" content="https://i.imgur.com/j017Uof.png"><meta property="og:url" content="https://cc.fruit/"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/css/bootstrap.min.css"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4/css/font-awesome.min.css"><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&amp;display=swap"><style>[v-cloak] {
  display: none;
}

body, .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
  font-family: "Noto Sans TC", sans-serif;
}</style><style>#businesscards .card-body {
  border-top: 1px solid rgba(0, 0, 0, 0.125);
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
})()</script><script async src="https://www.googletagmanager.com/gtag/js?id=G-GZZ1VHK5ZD"></script><script>;(() => {
  // initialize gtag
  window.dataLayer = window.dataLayer || []
  function gtag(){window.dataLayer.push(arguments)}
  gtag.id = 'G-GZZ1VHK5ZD'
  gtag('js', new Date())
  gtag('config', gtag.id)

  // set LINE userId
  gtag.configUserId = userId => {
    if (!_.isString(userId)) return
    gtag('config', gtag.id, { user_id: userId })
  }

  // send event
  gtag.event = (name, params) => { gtag('event', name, params) }

  gtag.genClientId = () => `${_.random(2147483647)}.${Math.trunc(Date.now() / 1e3)}`

  gtag.genClientIdByLineId = (lineId = '') => {
    if (!/U[0-9a-f]{32}$/.test(lineId)) lineId = 'Udeadbeefdeadbeefdeadbeefdeadbeef'
    const u32s = new Uint32Array(_.map(lineId.slice(1).match(/.{8}/g), hex => _.parseInt(hex, 16)))
    for (let i = 0; i < 2; i++) u32s[i] ^= u32s[i + 2]
    return `${u32s[0]}.${u32s[1]}`
  }

  gtag.mpCollectUrl = json => {
    const url = new URL('https://gcf-line-devbot-ybtjbo45iq-uc.a.run.app/mp/collect')
    url.searchParams.set('measurement_id', gtag.id)
    url.searchParams.set('api_secret', 'ao5gdSy9S4S8abEITAYwfQ')
    if (!json.client_id) json.client_id = gtag.genClientId()
    url.searchParams.set('json', window.encodeBase64url(JSON5.stringify(window.beautifyFlex(json))))
    return url.href
  }

  window.gtag = gtag // expose gtag
})()</script><nav class="navbar navbar-expand-lg navbar-dark bg-dark"><a class="navbar-brand mb-0 h1" href="https://cc.fruit/">LINE 數位版名片</a><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#businesscard-navbar"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="businesscard-navbar"><ul class="navbar-nav mr-auto"><li class="nav-item"><a class="nav-link" href="https://cc.fruit/"><i class="fa fa-fw fa-list"></i> 首頁</a></li><li class="nav-item"><a class="nav-link" target="_blank" href="https://developers.line.biz/flex-simulator/"><i class="fa fa-fw fa-eye"></i> Flex 訊息模擬器</a></li></ul></div></nav><div class="container my-4" id="app" v-cloak><h1 class="my-3 text-center">免費樣版列表</h1><div class="row row-cols-1 row-cols-md-2 row-cols-xl-3" id="businesscards"><div class="col mb-4" v-for="card in businesscards"><div class="card h-100"><img class="card-img-top" :src="card.preview" style="aspect-ratio: 1280/640"><div class="card-body d-flex flex-column"><h5 class="card-title">{{ card.name }}</h5><h6 class="card-subtitle mb-2 text-muted">By {{ card.author }}</h6><p class="card-text">{{ card.description }}</p><a class="btn btn-primary mt-auto" :href="baseurl + card.form"><i class="fa mr-2 fa-id-card-o"></i> 點此建立名片</a></div></div></div></div></div>@endverbatim<script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/crypto-js@3/crypto-js.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/js-base64@3/base64.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/json5@2/dist/index.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/lodash@4/lodash.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/pako@2/dist/pako.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/papaparse@5/papaparse.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/popper.js@1/dist/umd/popper.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/qs@6/dist/qs.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/vue-i18n@8/dist/vue-i18n.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/js/bootstrap.min.js"></script>@verbatim<script src="https://cc.fruit/js/common.js?cachebust=1696238313165"></script>@endverbatim<script>const vm = new Vue({ // eslint-disable-line
  el: '#app',
  data: {
    baseurl: 'https://cc.fruit/',
    businesscards: [],
  },
  async mounted () {
    try {
      this.businesscards = await window.getCsv('https://cc.fruit/businesscards.csv')
    } catch (err) {
      await Swal.fire({ icon: 'error', title: '初始化失敗', text: err.message })
    }
  },
})</script></body></html>