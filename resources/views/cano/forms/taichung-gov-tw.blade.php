<!DOCTYPE html><html><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover, user-scalable=no"><title>臺中市政府</title><meta name="description" content="臺中市政府"><meta property="og:description" content="臺中市政府"><meta property="og:title" content="臺中市政府"><meta property="og:type" content="website"><meta property="og:image:height" content="640"><meta property="og:image:width" content="1280"><meta property="og:image" content="https://i.imgur.com/fNmX6oa.png"><meta property="og:url" content="https://cc.fruit/forms/taichung-gov-tw.html"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/css/bootstrap.min.css"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4/css/font-awesome.min.css"><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&amp;display=swap"><style>[v-cloak] {
  display: none;
}

body, .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
  font-family: "Noto Sans TC", sans-serif;
}

input, textarea {
  font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace !important;
}

.swal2-textarea.form-control {
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  color: #495057;
  border-radius: 0.25rem;
}
.swal2-textarea.form-control-sm {
  padding: 0.25rem 0.5rem;
  font-size: 0.875rem;
  border-radius: 0.2rem;
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
})()</script><nav class="navbar navbar-expand-lg navbar-dark bg-dark"><a class="navbar-brand mb-0 h1" href="https://cc.fruit/">LINE 數位版名片</a><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#businesscard-navbar"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="businesscard-navbar"><ul class="navbar-nav mr-auto"><li class="nav-item"><a class="nav-link" href="https://cc.fruit/"><i class="fa fa-fw fa-list"></i> 首頁</a></li><li class="nav-item"><a class="nav-link" target="_blank" href="https://developers.line.biz/flex-simulator/"><i class="fa fa-fw fa-eye"></i> Flex 訊息模擬器</a></li></ul></div></nav><div class="container my-4" id="app" v-cloak><h2 class="my-3 text-center">臺中市政府</h2><div class="form-group was-validated my-2"><label for="vcard-name">姓名</label><input class="form-control form-control-sm" id="vcard-name" type="text" required pattern=".+" v-model="vcard.name"><small class="form-text text-muted">請填寫姓名，每個字的中間加入空格會更美觀。</small></div><div class="form-group was-validated my-2"><label for="vcard-title">職稱</label><input class="form-control form-control-sm" id="vcard-title" type="text" required pattern=".+" v-model="vcard.title"><small class="form-text text-muted">請填寫職稱。</small></div><div class="form-group was-validated my-2"><label for="vcard-tel">電話</label><input class="form-control form-control-sm" id="vcard-tel" type="tel" inputmode="tel" required pattern="[0-9,+-]+" v-model="vcard.tel"><small class="form-text text-muted">請填寫單位電話。</small></div><div class="form-group was-validated my-2"><label for="vcard-fax">傳真</label><input class="form-control form-control-sm" id="vcard-fax" type="tel" inputmode="tel" required pattern="[0-9,+-]+" v-model="vcard.fax"><small class="form-text text-muted">請填寫單位傳真。</small></div><div class="form-group was-validated my-2"><label for="vcard-email">信箱</label><input class="form-control form-control-sm" id="vcard-email" type="email" inputmode="email" required pattern=".+" v-model="vcard.email"><small class="form-text text-muted">請填寫信箱。</small></div><div class="form-group was-validated my-2"><label for="vcard-unit">單位</label><input class="form-control form-control-sm" id="vcard-unit" type="text" required pattern=".+" v-model="vcard.unit"><small class="form-text text-muted">請填寫單位名稱。</small></div><div class="form-group was-validated my-2"><label for="vcard-address">地址</label><input class="form-control form-control-sm" id="vcard-address" type="text" required pattern=".+" v-model="vcard.address"><small class="form-text text-muted">請填寫單位的地址。</small></div><div class="form-group was-validated my-2"><label for="vcard-maps">地圖</label><textarea class="form-control form-control-sm" id="vcard-maps" inputmode="url" required pattern="https?://\S+" v-model="vcard.maps" rows="3"></textarea><small class="form-text text-muted">請填寫單位的 Google 地圖網址。</small></div><div class="form-group was-validated my-2"><label for="vcard-url">網站</label><textarea class="form-control form-control-sm" id="vcard-url" inputmode="url" required pattern="(https?://|line://|tel:|mailto:)\S+" v-model="vcard.url" rows="3"></textarea><small class="form-text text-muted">請填寫單位網站。</small></div><div class="row mx-n2 my-2 d-flex"><button class="btn btn-danger flex-fill mx-2 my-1" type="button" @click="btnReset"><i class="fa mr-2 fa-repeat"></i> 重設表單</button><button class="btn btn-info flex-fill mx-2 my-1" type="button" @click="btnExport"><i class="fa mr-2 fa-code"></i> 匯出匯入</button><a class="btn btn-primary flex-fill mx-2 my-1" :href="shortcut" target="_blank"><i class="fa mr-2 fa-id-card-o"></i> 建立名片</a></div><div class="modal fade" id="modal-exportimport" data-backdrop="static" data-keyboard="false" tabindex="-1" ref="modalExportImport"><div class="modal-dialog modal-dialog-centered modal-xl align-items-stretch"><div class="modal-content"><div class="modal-body d-flex flex-column"><textarea class="form-control form-control-sm flex-fill" v-model="exportimport.text"></textarea><small class="text-muted form-text">請複製匯出的資料，或貼上之前的資料並點一下「匯入」按鈕。</small></div><div class="modal-footer"><button class="btn btn-outline-success" type="button" @click="btnCopy(exportimport.text, $refs['modalExportImport'])">複製</button><button class="btn btn-secondary" type="button" @click="jqModal('modalExportImport', 'hide')">關閉</button><button class="btn btn-primary" type="button" @click="btnImport">匯入</button></div></div></div></div></div>@endverbatim<script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/crypto-js@3/crypto-js.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/js-base64@3/base64.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/json5@2/dist/index.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/lodash@4/lodash.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/pako@2/dist/pako.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/papaparse@5/papaparse.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/popper.js@1/dist/umd/popper.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/qs@6/dist/qs.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/js/bootstrap.min.js"></script><script src="https://cc.fruit/js/common.js?cachebust=1696238315416"></script><script>@verbatim
window.vueConfig = {
  el: '#app',
  data: {
    exportimport: {
      text: '',
      visible: false,
    },
  },
  async mounted () {
    try {
      window.gtag.event('open_template_form', { template_name: document.title })
      window.backupVcard = JSON5.stringify(_.get(this, 'vcard', {}))
      this.loadVcard()
      await this.onloadVcard()
      this.watchVcard()
    } catch (err) {
      await Swal.fire({ icon: 'error', title: '初始化失敗', text: err.message })
      await this.btnReset(false)
      location.reload()
    }
  },
  computed: {
    shortcut () {
      const params = window.httpBuildQuery(_.mapValues(this.vcard, window.encodeBase64url))
      if (!_.isString(params) || !params.length) return
      return `https://liff.line.me/1661414135-95aMGZzm/share.html?${params}`
    },
  },
  methods: {
    loadVcard () {
      try {
        const saved = JSON5.parse(localStorage.getItem(location.pathname))
        if (saved) this.$set(this, 'vcard', { ...this.vcard, ...saved })
      } catch (err) {}
    },
    async onloadVcard () {}, // abstract
    watchVcard () {
      this.$watch('vcard', () => {
        localStorage.setItem(location.pathname, JSON5.stringify(this.vcard))
      }, { deep: true })
    },
    async btnReset (confirm = true) {
      try {
        if (confirm) {
          window.gtag.event('reset_template_form', { template_name: document.title })
          confirm = await Swal.fire({
            cancelButtonColor: '#3085d6',
            cancelButtonText: '保持原樣',
            confirmButtonColor: '#d33',
            confirmButtonText: '重設資料',
            focusCancel: true,
            icon: 'warning',
            showCancelButton: true,
            text: '請問你是否要是否重設本頁面的資料？',
          })
          if (!confirm.value) return
        }

        this.$set(this, 'vcard', JSON5.parse(window.backupVcard))
        this.onloadVcard()
      } catch (err) {
        window.logError({ err, fatal: true })
      }
    },
    async exportVcard () {
      return JSON.stringify(window.beautifyFlex(this.vcard), null, 2)
    },
    async importVcard (imported) {
      imported = window.parseJsonOrDefault(imported)
      if (!imported) throw new Error('無法解析匯入的 JSON5')
      this.$set(this, 'vcard', imported)
    },
    async btnCopy (text, container = null) {
      if (!container) container = document.body
      const dom = document.createElement('textarea')
      dom.value = text
      container.appendChild(dom)
      dom.select()
      dom.setSelectionRange(0, 1e6) // For mobile devices
      document.execCommand('copy')
      container.removeChild(dom)
      await Swal.fire({ icon: 'success', title: '複製成功' })
    },
    async btnExport () {
      try {
        const exported = await this.exportVcard()
        this.exportimport.text = exported
        this.jqModal('modalExportImport', 'show')
      } catch (err) {
        window.logError({ err, fatal: true })
        await Swal.fire({ icon: 'error', title: '匯出失敗', text: err.message })
      }
    },
    async btnImport () {
      try {
        this.jqModal('modalExportImport', 'hide')
        const imported = _.trim(this.exportimport.text)
        console.log({ imported })
        await this.importVcard(imported)
        this.exportimport.text = ''
      } catch (err) {
        window.logError({ err })
        await Swal.fire({ icon: 'error', title: '匯入失敗', text: err.message })
      }
    },
    jqModal (ref, action) {
      window.jQuery(this.$refs[ref]).modal(action)
    },
  },
}
@endverbatim</script><script>window.vueConfig.data.vcard = {
  address: '40341 臺中市西區民權路105號',
  email: 'xxx@taichung.gov.tw',
  maps: 'https://www.google.com/maps/search/?api=1&query_place_id=ChIJX-E3dG92bjQRLAnfoUA85v4&query=%E8%87%BA%E4%B8%AD%E5%B8%82%E4%B8%AD%E8%A5%BF%E5%8D%80%E8%A1%9B%E7%94%9F%E6%89%80&openExternalBrowser=1',
  name: '王 小 美',
  tel: '04-22223811,000',
  fax: '04-22202852',
  template: 'https://cc.fruit/cards/taichung-gov-tw.txt',
  title: '護理師',
  unit: '臺中市中西區衛生所',
  url: 'https://www.westcentralphc.taichung.gov.tw/?openExternalBrowser=1',
}</script><script>@verbatim
(async () => {
  if (_.isFunction(window.beforeVueCreate)) await window.beforeVueCreate()
  window.vm = new Vue(window.vueConfig)
})()
@endverbatim</script></body></html>