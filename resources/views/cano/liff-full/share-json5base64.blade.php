<!DOCTYPE html><html><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover, user-scalable=no"><title>分享 LINE 數位版名片</title><meta name="description" content="請開啟本連結並按一下「分享好友」來分享給好友或群組。"><meta property="fb:app_id" content="2133031763635285"><meta property="og:description" content="請開啟本連結並按一下「分享好友」來分享給好友或群組。"><meta property="og:locale" content="zh_TW"><meta property="og:site_name" content="LINE 數位版名片"><meta property="og:title" content="分享 LINE 數位版名片"><meta property="og:type" content="website"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/css/bootstrap.min.css"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4/css/font-awesome.min.css"><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&amp;display=swap"><style>[v-cloak] {
  display: none;
}

body, .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
  font-family: "Noto Sans TC", sans-serif;
}</style><meta property="og:image:height" content="630"><meta property="og:image:width" content="1200"><meta property="og:image" content="https://i.imgur.com/1KZoSue.png">@verbatim<meta property="og:url" content="https://liff.line.me/1661414135-95aMGZzm/share.html">@endverbatim<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/PamornT/flex2html@main/css/flex2html.css"><style>[v-cloak] {
  display: none;
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
})()</script>@verbatim<div class="container my-4 text-monospace" id="app" v-cloak v-show="!loading"><h3 class="my-3 text-center">{{ $t('title') }}</h3><div class="form-group my-3"><button class="btn btn-lg btn-success btn-block d-flex justify-content-center align-items-center" type="button" @click="btnShare" :disabled="!msgs"><i class="fa mr-2 fa-share-square-o"></i> {{ $t('share.btn') }}</button><small class="form-text text-muted mt-2">{{ $t('share.help') }}</small></div><div class="form-group my-3"><button class="btn btn-lg btn-info btn-block d-flex justify-content-center align-items-center" type="button" @click="btnSend" :disabled="!msgs"><i class="fa mr-2 fa-paper-plane-o"></i> {{ $t('send.btn') }}</button><small class="form-text text-muted mt-2">{{ $t('send.help') }}</small></div><div class="form-group my-3"><div class="btn-group btn-group-lg w-100"><button class="btn btn-outline-secondary btn-block d-flex justify-content-center align-items-center" type="button" @click="btnCopy(linkLiffV2)"><i class="fa mr-2 fa-clipboard"></i> {{ $t('copy.btn') }}</button><button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-toggle="dropdown"></button><div class="dropdown-menu dropdown-menu-right"><button class="dropdown-item" type="button" @click="btnCopy(linkLiffV1)">{{ $t('copy.btn') }} (LIFF v1)</button><button class="dropdown-item" type="button" @click="btnCopy(linkLihi)">{{ $t('copy.btn') }} (lihi1.com)</button></div></div><small class="form-text text-muted mt-2">{{ $t('copy.help') }}</small></div><div class="dropdown my-3"><button class="btn btn-lg btn-secondary btn-block dropdown-toggle" type="button" data-toggle="dropdown">{{ $t('dropdown.btn') }}</button><div class="dropdown-menu"><a class="dropdown-item" target="_blank" href="https://line.me/R/nv/QRCodeReader"><i class="fa fa-fw fa-qrcode"></i> {{ $t('dropdown.qrcodeReader') }}</a><a class="dropdown-item" target="_blank" href="https://line.me/R/nv/addFriends"><i class="fa fa-fw fa-users"></i> {{ $t('dropdown.addFriends') }}</a><a class="dropdown-item" target="_blank" href="https://line.me/R/nv/keep"><i class="fa fa-fw fa-bookmark"></i> {{ $t('dropdown.keep') }}</a><a class="dropdown-item" target="_blank" href="https://cc.fruit/?openExternalBrowser=1"><i class="fa fa-fw fa-address-card"></i> {{ $t('dropdown.create') }}</a><a class="dropdown-item" target="_blank" href="https://lihi1.com/CVjIx/liffshare"><i class="fa fa-fw fa-comments"></i> {{ $t('dropdown.discuss') }}</a><button class="dropdown-item" type="button" @click="btnFriendMissing"><i class="fa fa-fw fa-question-circle"></i> {{ $t('dropdown.friendMissing') }}</button></div></div><div class="table-responsive" style="background-color: #849ebf"><div class="chatbox pt-3"><div id="flex2html" ref="flex2html"></div></div></div></div>@endverbatim@endverbatim<script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/crypto-js@3/crypto-js.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/js-base64@3/base64.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/json5@2/dist/index.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/lodash@4/lodash.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/pako@2/dist/pako.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/papaparse@5/papaparse.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/popper.js@1/dist/umd/popper.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/qs@6/dist/qs.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/vue-i18n@8/dist/vue-i18n.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/js/bootstrap.min.js"></script>@verbatim<script src="https://cc.fruit/js/common.js?cachebust=1696238316185"></script>@endverbatim<script crossorigin="anonymous" src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/gh/PamornT/flex2html@main/js/flex2html.min.js"></script><script>@verbatim
const loginPromise = (async () => {
  await liff.init({ liffId: '1661414135-95aMGZzm' })
  if (window.getSearchParam('liff.state')) await new Promise(resolve => {}) // 永遠不會結束的 Promise
  if (!liff.isLoggedIn()) {
    liff.login({ redirectUri: location.href })
    await new Promise(resolve => {}) // 永遠不會結束的 Promise
  }
  const profile = await liff.getProfile().catch(err => {
    window.logError({ err })
    return {}
  })
  window.gtag.configUserId(profile.userId)
  return profile
})()
window.vueConfig = {
  el: '#app',
  data: {
    linkLiffV1: null,
    linkLiffV2: null,
    linkLihi: null,
    loading: true,
    msgs: null,
    profile: null,
    render: null,
    vcard: null,
  },
  async mounted () {
    try {
      this.showLoading(this.$t('wait'), this.$t('init.loading'))
      this.profile = await loginPromise
      this.linkLiffV2 = liff.permanentLink.createUrl()
      this.setOtherLinksByLiffV2(this.linkLiffV2)
      await Promise.all([
        this.getTpl(),
        this.getVcard(),
      ])
      console.log('vcard', this.vcard)
      this.msgs = this.getRenderedMsgs()
      console.log('msgs', this.msgs)
      for (const msg of this.msgs) {
        window.flex2html('flex2html', msg)
      }
      this.hideLoading()
      await this.showSavedAlert()
    } catch (err) {
      window.logError({ err, fatal: true })
      await this.swalFire({ icon: 'error', title: this.$t('init.fail'), text: err.message })
    }
    if (liff.isInClient() && liff.isApiAvailable('shareTargetPicker')) await this.btnShare(true)
    this.loading = false
  },
  computed: {
    locale: {
      get () { return this.$i18n.locale },
      set (newVal) { this.$i18n.locale = newVal },
    },
  },
  methods: {
    async getTpl () {
      try {
        const tpl = this.paramBase64url('template')
        if (!tpl) throw new Error('template is required.')
        const render = _.template(_.get(await axios.get(tpl, {
          params: { cachebust: Date.now() },
          transformResponse: [],
        }), 'data'))
        if (!_.isFunction(render)) throw new Error('')
        const liffLink = this.isInOpenChat() ? this.linkLiffV1 : this.linkLiffV2
        const { profile = {} } = this

        // generate fake page_view for template_impression
        const baks = _.fromPairs(await Promise.all(['client_id', 'session_id', 'user_id'], async k => {
          const val = await new Promise(resolve, gtag('get', gtag.id, k, resolve))
          return [k, val]
        }))
        // generate clientId by line userId
        const gtagClientId = gtag.genClientIdByLineId(profile.userId)
        const gtagSessionId = `${liff.getDecodedIDToken()?.iat ?? Math.trunc(Date.now() / 1e3)}`
        gtag('event', 'page_view', {
          client_id: gtagClientId,
          page_location: location.href,
          page_title: document.title,
          session_id: gtagSessionId,
          user_id: null,
        })
        gtag('config', gtag.id, baks)

        this.render = options => render({ gtagClientId, gtagSessionId, liffLink, profile, ...options })
      } catch (err) {
        err.message = `${this.$t('init.getTplFail')}${err.message ? ': ' + err.message : ''}`
        this.render = null
        throw err
      }
    },
    async getVcard () {
      this.vcard = _.mapValues(_.omit(_.fromPairs([...new URL(location).searchParams]), [
        'code',
        'liffClientId',
        'liffRedirectUri',
        'state',
        'template',
      ]), window.decodeBase64url)
    },
    async btnShare (slient = false) {
      try {
        this.showLoading(this.$t('wait'), this.$t('share.loading'))
        window.gtag.event('template_share', { method: 'liff_share', template_url: this.vcard.template })
        if (!liff.isApiAvailable('shareTargetPicker')) throw new Error(this.$t('share.unsupported'))
        const beforeShare = Date.now()
        const res = await liff.shareTargetPicker(this.msgs)
        const afterShare = Date.now()
        if (_.get(res, 'status') !== 'success') {
          if (!slient) throw new Error(this.$t('share.canceled'))
          return
        }
        await this.swalFire({ icon: 'success', title: this.$t('share.success') })
        if (afterShare - beforeShare > 1e3) liff.closeWindow()
      } catch (err) {
        window.logError({ err })
        await this.swalFire({ icon: 'error', title: this.$t('share.fail'), text: err.message })
      } finally {
        this.hideLoading()
      }
    },
    async btnSend () {
      try {
        this.showLoading(this.$t('wait'), this.$t('send.loading'))
        window.gtag.event('template_share', { method: 'liff_send', template_url: this.vcard.template })
        if (!this.canSendMessages()) throw new Error(this.$t('send.unsupported'))
        await liff.sendMessages(this.msgs)
        await this.swalFire({ icon: 'success', title: this.$t('send.success') })
        liff.closeWindow()
      } catch (err) {
        window.logError({ err })
        await this.swalFire({ icon: 'error', title: this.$t('send.fail'), text: err.message })
      }
    },
    async btnCopy (text, container = null) {
      window.gtag.event('clipboard_copy', { content_type: 'text', text: _.truncate(text, { length: 30, omission: '' }) })
      if (!container) container = document.body
      const dom = document.createElement('textarea')
      dom.value = text
      container.appendChild(dom)
      dom.select()
      dom.setSelectionRange(0, 1e6) // For mobile devices
      document.execCommand('copy')
      container.removeChild(dom)
      await this.swalFire({ icon: 'success', title: this.$t('copy.success') })
    },
    async showSavedAlert () {
      const swalFire = window.parseJsonOrDefault(localStorage.getItem('swalFire'))
      localStorage.removeItem('swalFire')
      if (_.isNil(swalFire)) return
      await this.swalFire(swalFire)
    },
    async btnFriendMissing () {
      await this.swalFire({
        padding: '0',
        customClass: { actions: 'mt-0 mb-2', content: 'pt-3 px-3' },
        html: this.$t('dropdown.friendMissingHtml'),
      })
    },
    async swalFire (args) {
      if (_.isPlainObject(args)) args = { footer: this.$t('swalFooter'), ...args }
      return await Swal.fire(args)
    },
    getRenderedMsgs () {
      let msg = this.render({ vcard: this.vcard })
      msg = JSON5.parse(msg)
      if (_.includes(['bubble', 'carousel'], _.get(msg, 'type'))) {
        msg = { type: 'flex', altText: this.$t('flexAltText'), contents: msg }
      }
      msg = _.castArray(msg)
      return msg
    },
    canSendMessages () {
      if (!liff.isInClient()) return false
      const contextType = _.get(liff.getContext(), 'type')
      if (!_.includes(['utou', 'room', 'group', 'square_chat'], contextType)) return false
      return true
    },
    paramBase64url (key) {
      const base64 = window.getSearchParam(key)
      return base64 ? window.decodeBase64url(base64) : null
    },
    paramGzip (key) {
      const base64 = window.getSearchParam(key)
      return base64 ? window.decodeGzip(base64) : null
    },
    setOtherLinksByLiffV2 (v2) {
      const match = v2.match(/^.*?\/(\d+-[^/]+)\/(.*)$/)
      const path = encodeURIComponent(match[2])
      this.linkLiffV1 = `https://line.me/R/app/${match[1]}?redirect=${path}`
      this.linkLihi = `https://lihi1.com/hFW7P/${path}`
    },
    isInOpenChat () {
      const context = liff.getContext()
      return _.get(context, 'type') === 'square_chat'
    },
    showLoading (title, text) {
      Swal.fire({
        title,
        text,
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => { Swal.showLoading() },
      })
    },
    hideLoading () {
      Swal.close()
    },
  },
}
@endverbatim</script><!-- vue-i18n-->@verbatim<script>window.i18nMessages = (window.i18nMessages || {})
window.i18nMessages.en = { // vm.$i18n.locale='en'
  flexAltText: 'Please check the vcard on mobile.',
  swalFooter: '<a target="_blank" href="https://lihi1.com/CVjIx/swal-footer">Having questions? Join LINE discuss group!</a>',
  title: 'Share LINE vcard',
  wait: 'Loading',
  copy: {
    btn: 'Copy URL',
    help: 'Click the "Copy URL" button and save to "LINE Keep."',
    success: 'Copied',
  },
  csv: {
    getVcardFail: 'Failed to fetch vcard data from csv',
  },
  dropdown: {
    addFriends: 'Open "Add friends"',
    btn: 'More features',
    create: 'Create new "LINE vcard"',
    discuss: 'Join LINE discuss group',
    friendMissing: 'Friend not found?',
    friendMissingHtml: '<small class="text-left"><p>If you can\'t find your friends in the "Share vcard," you can try the following steps:</p><ol><li>Click the "Copy URL" button</li><li>Send the URL to any LINE chat</li><li>Open the URL in the LINE chat on mobile</li><li>Click the "Send vcard" button</li><li>Unsend URL in the LINE chat</li></ol></small>',
    keep: 'Open "LINE Keep"',
    qrcodeReader: 'Open "QRCode Reader"',
  },
  googlesheet: {
    getVcardFail: 'Failed to fetch vcard data from google sheet',
    invalidApiKey: 'Invalid Google api key',
    keyNotFound: 'Failed to find the "{key}" key from first row',
  },
  init: {
    fail: 'Failed to initialize',
    getTplFail: 'Failed to fetch vcard template',
    loading: 'Initializing…',
  },
  send: {
    btn: 'Send vcard',
    fail: 'Failed to send vcard',
    help: 'Click the "Send vcard" button to send vcard to the chat directly.',
    loading: 'Sending vcard…',
    success: 'Sent',
    unsupported: 'Please click the "Copy URL" button first, then paste and open the URL in the LINE chat on mobile.',
  },
  share: {
    btn: 'Share vcard',
    canceled: 'Share canceled',
    fail: 'Failed to share vcard',
    help: 'Click the "Share vcard" button to share with friends or groups.',
    loading: 'Sharing vcard…',
    success: 'Shared',
    unsupported: 'The share feature is not supported, please try to update the LINE APP.',
  },
}</script><script>window.i18nMessages = (window.i18nMessages || {})
window.i18nMessages['zh-TW'] = { // vm.$i18n.locale='zh-TW'
  flexAltText: '請在手機上查看數位版名片。',
  swalFooter: '<a target="_blank" href="https://lihi1.com/CVjIx/swal-footer">遇到問題？點此加入技術討論群！</a>',
  title: '分享 LINE 數位版名片',
  wait: '請稍候',
  copy: {
    btn: '複製網址',
    help: '按一下「複製網址」按鈕，然後存到 LINE Keep。',
    success: '複製成功',
  },
  csv: {
    getVcardFail: '無法從 csv 讀取資料',
  },
  dropdown: {
    addFriends: '點此前往「加入好友」',
    btn: '點此查看更多功能',
    create: '製作新的「LINE 數位版名片」',
    discuss: '加入技術討論社群',
    friendMissing: '在「分享好友」中找不到好友？',
    friendMissingHtml: '<small class="text-left"><p>如果在「分享好友」的清單中找不到好友，你可以嘗試以下步驟：</p><ol><li>按一下「複製網址」按鈕</li><li>進到聊天室並「貼上」網址</li><li>在好友的聊天室中「開啟」名片網址</li><li>按一下「直接傳送」按鈕傳送名片</li><li>在好友的聊天室中「收回」名片網址</li></ol></small>',
    keep: '點此前往「LINE Keep」',
    qrcodeReader: '點此掃描「行動條碼」',
  },
  googlesheet: {
    getVcardFail: '無法從 Google 試算表讀取資料',
    invalidApiKey: '無效的 Google API 金鑰',
    keyNotFound: '無法從試算表的第一列中找到「{key}」',
  },
  init: {
    fail: '頁面初始化失敗',
    getTplFail: '名片樣板獲取失敗',
    loading: '頁面初始化中…',
  },
  send: {
    btn: '直接傳送',
    fail: '傳送失敗',
    help: '按一下「直接傳送」按鈕，可以直接傳送到聊天室。',
    loading: '正在傳送名片…',
    success: '傳送成功',
    unsupported: '請先按「複製網址」，然後在 LINE 聊天視窗內貼上並開啟該網址，才有辦法使用「直接傳送」功能喔！',
  },
  share: {
    btn: '分享好友',
    canceled: '使用者取消分享',
    fail: '分享失敗',
    help: '按一下「分享好友」按鈕，可以分享給好友或群組。',
    loading: '正在分享名片…',
    success: '分享成功',
    unsupported: '不支援 shareTargetPicker，請嘗試更新應用程式版本。',
  },
}</script>@endverbatim<script>const cfg = window.vueConfig
cfg.methods.getVcard = async function () {
  try {
    this.vcard = window.parseJsonOrDefault(this.paramBase64url('json5base64'), {})
  } catch (err) {
    err.message = `${this.$t('csv.getVcardFail')}${err.message ? ': ' + err.message : ''}`
    this.render = null
    throw err
  }
}</script><script>@verbatim
(async () => {
  if (_.isFunction(window.beforeVueCreate)) await window.beforeVueCreate()
  window.vueConfig.i18n = new VueI18n({ // vue-i18n
    locale: navigator.language,
    fallbackLocale: 'zh-TW',
    messages: (window.i18nMessages || {}),
  })
  window.vm = new Vue(window.vueConfig)
})()
@endverbatim</script></body></html>