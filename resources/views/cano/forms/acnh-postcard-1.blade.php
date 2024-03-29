<!DOCTYPE html><html><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover, user-scalable=no"><title>動物森友會心意卡</title><meta name="description" content="來自「集合吧！動物森友會」的心意卡。"><meta property="og:description" content="來自「集合吧！動物森友會」的心意卡。"><meta property="og:title" content="動物森友會心意卡"><meta property="og:type" content="website"><meta property="og:image:height" content="640"><meta property="og:image:width" content="1280"><meta property="og:image" content="https://i.imgur.com/gJASJdW.png"><meta property="og:url" content="https://cc.fruit/forms/acnh-postcard-1.html"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/css/bootstrap.min.css"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4/css/font-awesome.min.css"><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&amp;display=swap"><style>[v-cloak] {
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
}</style><style>#designs .btn-sm {
  font-size: 0.75rem;
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
})()</script><nav class="navbar navbar-expand-lg navbar-dark bg-dark"><a class="navbar-brand mb-0 h1" href="https://cc.fruit/">LINE 數位版名片</a><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#businesscard-navbar"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="businesscard-navbar"><ul class="navbar-nav mr-auto"><li class="nav-item"><a class="nav-link" href="https://cc.fruit/"><i class="fa fa-fw fa-list"></i> 首頁</a></li><li class="nav-item"><a class="nav-link" target="_blank" href="https://developers.line.biz/flex-simulator/"><i class="fa fa-fw fa-eye"></i> Flex 訊息模擬器</a></li></ul></div></nav><div class="container my-4" id="app" v-cloak><h2 class="my-3 text-center">動物森友會心意卡</h2><div class="form-group my-2"><label for="vcard-design">卡片底圖</label><select class="form-control d-sm-none" id="vcard-design" v-model="vcard.design"><option v-for="(design, id) of designs" :value="id">{{ design.name }}</option></select><small class="form-text text-muted d-sm-none">請選擇卡片的底圖。</small><img class="my-2 rounded d-block d-sm-none mx-auto" v-if="vcard.design" :src="`https://i.imgur.com/${_.get(designs, [vcard.design, 'imgur'])}m.png`" style="max-width: 320px"><div class="ml-0 row row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xl-5 d-none d-sm-flex" id="designs"><div class="col mb-1 pl-0" v-for="(design, id) of designs"><div class="card" @click="vcard.design = id"><img class="card-img-top" :src="`https://i.imgur.com/${design.imgur}m.png`"><div class="card-body p-1"><button class="btn btn-primary btn-block btn-sm px-1" type="button" v-if="vcard.design === id" disabled>已選擇「{{ design.name }}」</button><button class="btn btn-outline-primary btn-block btn-sm px-1" type="button" @click="vcard.design = id" v-else>選擇「{{ design.name }}」</button></div></div></div></div></div><div class="form-group was-validated my-2"><label for="vcard-to">收件人</label><input class="form-control form-control-sm" id="vcard-to" type="text" required pattern=".+" v-model="vcard.to"><small class="form-text text-muted">請填寫卡片收件人。</small></div><div class="form-group was-validated my-2"><label for="vcard-from">寄件人</label><input class="form-control form-control-sm" id="vcard-from" type="text" required pattern=".+" v-model="vcard.from"><small class="form-text text-muted">請填寫卡片寄件人。</small></div><div class="form-group was-validated my-2"><label for="vcard-body">卡片內容</label><textarea class="form-control form-control-sm" id="vcard-body" required pattern=".+" v-model="vcard.body" style="min-height: 200px"></textarea><small class="form-text text-muted">請填寫卡片內容。</small></div><div class="row mx-n2 my-2 d-flex"><button class="btn btn-danger flex-fill mx-2 my-1" type="button" @click="btnReset"><i class="fa mr-2 fa-repeat"></i> 重設表單</button><button class="btn btn-info flex-fill mx-2 my-1" type="button" @click="btnExport"><i class="fa mr-2 fa-code"></i> 匯出匯入</button><a class="btn btn-primary flex-fill mx-2 my-1" :href="shortcut" target="_blank"><i class="fa mr-2 fa-id-card-o"></i> 建立名片</a></div><div class="modal fade" id="modal-exportimport" data-backdrop="static" data-keyboard="false" tabindex="-1" ref="modalExportImport"><div class="modal-dialog modal-dialog-centered modal-xl align-items-stretch"><div class="modal-content"><div class="modal-body d-flex flex-column"><textarea class="form-control form-control-sm flex-fill" v-model="exportimport.text"></textarea><small class="text-muted form-text">請複製匯出的資料，或貼上之前的資料並點一下「匯入」按鈕。</small></div><div class="modal-footer"><button class="btn btn-outline-success" type="button" @click="btnCopy(exportimport.text, $refs['modalExportImport'])">複製</button><button class="btn btn-secondary" type="button" @click="jqModal('modalExportImport', 'hide')">關閉</button><button class="btn btn-primary" type="button" @click="btnImport">匯入</button></div></div></div></div></div>@endverbatim<script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/crypto-js@3/crypto-js.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/js-base64@3/base64.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/json5@2/dist/index.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/lodash@4/lodash.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/pako@2/dist/pako.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/papaparse@5/papaparse.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/popper.js@1/dist/umd/popper.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/qs@6/dist/qs.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.min.js"></script><script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/js/bootstrap.min.js"></script><script src="https://cc.fruit/js/common.js?cachebust=1696238313796"></script><script>@verbatim
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
@endverbatim</script><script>const cfg = window.vueConfig
cfg.data = {
  ...cfg.data,
  designs: {
    Academy00: { name: '快樂家協會卡片', imgur: 'zx0bo9H', bg: '#00000000', body: '#210E0A', from: '#210E0A', to: '#210E0A' },
    Active00: { name: '塗鴉卡片', imgur: '8sVICE9', bg: '#00000000', body: '#FBFE00', from: '#06FFEE', to: '#07F5DE' },
    Active01: { name: '星星卡片', imgur: 'Yihz9Sp', bg: '#00000000', body: '#0B3F71', from: '#C74400', to: '#C94304' },
    Baby00: { name: '嬰兒用品卡片', imgur: '8xIFyua', bg: '#00000000', body: '#58BFCE', from: '#66514C', to: '#68534E' },
    Bank00: { name: 'Nook卡片', imgur: 'DhzKAP5', bg: '#00000000', body: '#00572E', from: '#00572E', to: '#00572E' },
    Birthday00: { name: '生日蛋糕卡片', imgur: 'xfSp5hO', bg: '#00000000', body: '#543D1E', from: '#4E3717', to: '#523827' },
    Birthday01: { name: '蝴蝶結卡片', imgur: 'kRmLcN8', bg: '#00000000', body: '#5B544C', from: '#3F0211', to: '#420210' },
    Birthday02: { name: '氣球卡片', imgur: 'Mx6V72r', bg: '#FDFDF1', body: '#60563B', from: '#EA8803', to: '#F28100' },
    Christmas00: { name: '大樹卡片', imgur: 'JScyCqk', bg: '#00000000', body: '#FFFFFF', from: '#FFFFFF', to: '#FFFFFF' },
    Christmas01: { name: '聖誕卡片', imgur: 'Ed9XQhV', bg: '#00000000', body: '#6D0000', from: '#004120', to: '#004120' },
    Christmas02: { name: '溫暖針織衫卡片', imgur: 'XwEGa6x', bg: '#410000', body: '#FFFFFF', from: '#FFFFFF', to: '#FFFFFF' },
    Cool00: { name: '酷感卡片', imgur: 'vUdZO4P', bg: '#00000000', body: '#ADADAD', from: '#DEDEDE', to: '#DBDBDB' },
    Cool01: { name: '迷彩卡片', imgur: 'N02E9RM', bg: '#00000000', body: '#FFEEC8', from: '#E7E668', to: '#E3DF71' },
    Cute00: { name: '少女情懷卡片', imgur: 'ardsyJX', bg: '#00000000', body: '#FEE4CD', from: '#FFEDD5', to: '#FFE5CC' },
    Cute01: { name: '奇幻星星卡片', imgur: 'M64Qsv0', bg: '#00000000', body: '#6C30EA', from: '#F59531', to: '#F45FD7' },
    Dal00: { name: 'DodoAirlines', imgur: '0EehJ8p', bg: '#00000000', body: '#FFFFFF', from: '#FFFFFF', to: '#FFFFFF' },
    Easter00: { name: '復活節卡片', imgur: 'xy8lLHI', bg: '#FEFDE8', body: '#281511', from: '#281511', to: '#281511' },
    Elegant00: { name: '寶石卡片', imgur: 'NqT3l9r', bg: '#B8DEC7', body: '#2C8974', from: '#227D8F', to: '#278287' },
    Elegant01: { name: '優雅玫瑰卡片', imgur: 'zlTCtBf', bg: '#00000000', body: '#F2DAB8', from: '#EADB74', to: '#E8D77F' },
    Encourage00: { name: '幸福幸運草卡片', imgur: 'Z13sWEP', bg: '#00000000', body: '#164C01', from: '#6F4320', to: '#68491A' },
    Fall00: { name: '芒草與紅蜻蜓卡片', imgur: '4ZNe5Nf', bg: '#00000000', body: '#BA6441', from: '#F26426', to: '#F96328' },
    Fall01: { name: '落葉地毯卡片', imgur: 'QoO9zNS', bg: '#00000000', body: '#FFDB83', from: '#FFDB83', to: '#FFDB83' },
    Fall02: { name: '蘑菇卡片', imgur: 'd6gbzkS', bg: '#00000000', body: '#E9CF85', from: '#EDE1AB', to: '#EDE1AB' },
    Fall03: { name: '橡栗卡片', imgur: 'uPD4aoV', bg: '#00000000', body: '#FFEB9E', from: '#FFEB9E', to: '#FFEB9E' },
    Father00: { name: '父親節卡片', imgur: 'qLzankT', bg: '#DEFFF4', body: '#0C4390', from: '#030956', to: '#030956' },
    Fish00: { name: '俞司廷卡片', imgur: 'Zd12B6F', bg: '#00000000', body: '#AD1600', from: '#E5DFC1', to: '#041554' },
    Gorgeous00: { name: '天鵝絨卡片', imgur: 'GI5FlDc', bg: '#00000000', body: '#EFBB67', from: '#BE8007', to: '#BF7D05' },
    Gorgeous01: { name: '裝飾風格卡片', imgur: 'FAEmCt7', bg: '#00000000', body: '#B34627', from: '#FCFAC9', to: '#FBFFC0' },
    Graduate00: { name: '畢業卡片', imgur: 'qdEuLWj', bg: '#00000000', body: '#FFFFFF', from: '#FFFFFF', to: '#FFFFFF' },
    Halloween00: { name: '南瓜卡片', imgur: 'FfLmydl', bg: '#00000000', body: '#EBC726', from: '#F6F1BB', to: '#F6F1BB' },
    Halloween01: { name: '萬聖節卡片', imgur: 'vLP3Bta', bg: '#00000000', body: '#FF5504', from: '#FFA907', to: '#FFA907' },
    Insect00: { name: '龍克斯卡片', imgur: '3sBBFby', bg: '#00000000', body: '#71BF73', from: '#71BF73', to: '#71BF73' },
    Love00: { name: '甜美愛心卡片', imgur: 'ObLF0ME', bg: '#00000000', body: '#DB5B5A', from: '#F09C9A', to: '#F09B9E' },
    Milage00: { name: 'Nook集哩遊卡片', imgur: 'PIHalBD', bg: '#00000000', body: '#23237D', from: '#23237D', to: '#23237D' },
    Mother00: { name: '母親節卡片', imgur: 'ZpdMXkX', bg: '#FFF1DE', body: '#900C37', from: '#560313', to: '#560313' },
    Newyear00: { name: '新年快樂卡片', imgur: 'c6lbsN4', bg: '#2C2289', body: '#975BFF', from: '#4864E9', to: '#FF7DE5' },
    Newyear01: { name: '日本富士山卡片', imgur: '1ICanEr', bg: '#00000000', body: '#0B0603', from: '#0B0603', to: '#0B0603' },
    Other00: { name: '和風卡片', imgur: 'Oq397My', bg: '#00000000', body: '#FEECD8', from: '#FCD671', to: '#FFCD71' },
    Other01: { name: '航空郵件卡片', imgur: '8RWEHRI', bg: '#00000000', body: '#000000', from: '#000000', to: '#000000' },
    Other03: { name: '文具卡片', imgur: 'OYieTy1', bg: '#00000000', body: '#707070', from: '#707070', to: '#707070' },
    Other04: { name: '齒輪卡片', imgur: 'ambQRKH', bg: '#00000000', body: '#96E7E0', from: '#FFFFFF', to: '#FFFFFF' },
    Other05: { name: '愛心滿滿卡片', imgur: 'HSoY5Wt', bg: '#00000000', body: '#FFF5FF', from: '#8A03E3', to: '#8F03E0' },
    Other06: { name: '藍天卡片', imgur: 'dL8u9KG', bg: '#00000000', body: '#DFF6FE', from: '#A7F2F8', to: '#A6EBFB' },
    Shopping00: { name: '禮物卡片', imgur: 'iSBQ8kU', bg: '#00000000', body: '#623300', from: '#623300', to: '#623300' },
    Simple00: { name: '常見卡片', imgur: 'LqBHztr', bg: '#00000000', body: '#825D55', from: '#825953', to: '#805B53' },
    Simple01: { name: '撕下的卡片', imgur: 'OavIsIR', bg: '#00000000', body: '#737373', from: '#6F6F6F', to: '#767676' },
    Snowfes00: { name: '雪人卡片', imgur: 'pF7P8jE', bg: '#00000000', body: '#FFFFFF', from: '#319FB0', to: '#369CB5' },
    Spring00: { name: '櫻花紛飛卡片', imgur: 'SJuzNsn', bg: '#00000000', body: '#480A1F', from: '#F41D61', to: '#F41D61' },
    Spring01: { name: '蒲公英卡片', imgur: 'IYUDElL', bg: '#00000000', body: '#DF2D04', from: '#033000', to: '#033000' },
    Spring02: { name: '繁花綻放卡片', imgur: 'Xtfayw7', bg: '#00000000', body: '#BF2000', from: '#520C03', to: '#520C03' },
    Star00: { name: '流星卡片', imgur: '8RL8od0', bg: '#00000000', body: '#DAEEF9', from: '#89E0F3', to: '#89DAED' },
    Summer00: { name: '金魚卡片', imgur: '7nfaLoz', bg: '#00000000', body: '#267D99', from: '#3E463B', to: '#3D4D43' },
    Summer01: { name: '積雨雲卡片', imgur: 'KQMtlxU', bg: '#00000000', body: '#001764', from: '#FFFFFF', to: '#0A0A10' },
    Summer02: { name: '扶桑花卡片', imgur: '9W44YVv', bg: '#F2F3F1', body: '#004868', from: '#DB0037', to: '#DB0037' },
    Summer03: { name: '沙灘卡片', imgur: 'OHtTcJO', bg: '#00000000', body: '#601600', from: '#3F0900', to: '#3F0900' },
    Sympathy00: { name: '絆創帶卡片', imgur: 'bz8ftDm', bg: '#00000000', body: '#1574AA', from: '#FFFFFF', to: '#FFFFFF' },
    Thanksgiving00: { name: '感謝祭卡片', imgur: 'jkTfSY3', bg: '#D49006', body: '#320300', from: '#791000', to: '#791000' },
    Thankyou00: { name: '捧花卡片', imgur: 'b5is08F', bg: '#00000000', body: '#9E2E00', from: '#673326', to: '#643A2A' },
    Thankyou01: { name: '幾何圖形卡片', imgur: 'NUB66Vd', bg: '#00000000', body: '#625952', from: '#3CC881', to: '#38C882' },
    Totakeke00: { name: 'K.K.卡片', imgur: 'OozIkDG', bg: '#00000000', body: '#443F3F', from: '#181818', to: '#181818' },
    Tsunekichi00: { name: '九尾狐利卡片', imgur: 'mVYhd2z', bg: '#00000000', body: '#002F36', from: '#002F36', to: '#002F36' },
    Valentine00: { name: '愛心巧克力卡片', imgur: 'RfEAXTG', bg: '#00000000', body: '#FFFFFF', from: '#FFD1EB', to: '#FFD1EB' },
    Valentine01: { name: '巧克力卡片', imgur: 'nAgMlBR', bg: '#00000000', body: '#FFE6E9', from: '#FFA63A', to: '#FFA63A' },
    Wedding00: { name: '結婚卡片', imgur: 'JriiP3Z', bg: '#00000000', body: '#76CAD4', from: '#4588BF', to: '#5190BB' },
    Winter00: { name: '雪花卡片', imgur: 'ZOz5Td9', bg: '#00000000', body: '#0075A3', from: '#3EA0BD', to: '#48A3BE' },
    Winter01: { name: '冬季山茶花卡片', imgur: 'c88UxVS', bg: '#00000000', body: '#424B6A', from: '#FFFFFF', to: '#FFFFFF' },
    Winter02: { name: '城市景色卡片', imgur: 'SOqnV1u', bg: '#00000000', body: '#7E1B00', from: '#5B0000', to: '#5B0000' },
  },
  vcard: {
    body: '我之前在岸邊散步時，\n突然冒出了新的 DIY 靈感！\n今天我就特別優待！\n把這個方程式告訴你吧！\n至於要怎麼做，就全看你自己了！',
    design: 'Active00',
    from: '將希望寄託於你的帕塔雅   筆',
    template: 'https://cc.fruit/cards/acnh-postcard-1.txt',
    to: '給偶然撿到這個瓶子的你',
  },
}</script><script>@verbatim
(async () => {
  if (_.isFunction(window.beforeVueCreate)) await window.beforeVueCreate()
  window.vm = new Vue(window.vueConfig)
})()
@endverbatim</script></body></html>