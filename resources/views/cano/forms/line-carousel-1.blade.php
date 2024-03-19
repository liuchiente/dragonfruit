<x-app-layout>

    <x-slot name="header">
        <h1 class="mt-4">多頁式輪播卡片</h1> 
    </x-slot>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Line卡片</li>
    </ol>
    
    <style>
        li.nav-item > 
        button.nav-link {
         color: #007bff;
         background-color: transparent;
         }
         .form-control.form-control-color, .was-validated .form-control.form-control-color:valid {
         -moz-appearance: none;
         -webkit-appearance: none;
         appearance: none;
         background: none;
         border: 1px solid #ced4da;
         padding: 0.375rem;
         width: 3rem;
         padding-right: 0.375rem !important;
         }
         .form-control.form-control-color:not(:disabled):not([readonly]), .was-validated .form-control.form-control-color:valid:not(:disabled):not([readonly]) {
         cursor: pointer;
         }
         .form-control.form-control-color::-moz-color-swatch, .was-validated .form-control.form-control-color:valid::-moz-color-swatch {
         border-radius: 0.25rem;
         border: none;
         }
         .form-control.form-control-color::-webkit-color-swatch, .was-validated .form-control.form-control-color:valid::-webkit-color-swatch {
         border-radius: 0.25rem;
         border: none;
         }
         .form-control.form-control-color::-webkit-color-swatch-wrapper, .was-validated .form-control.form-control-color:valid::-webkit-color-swatch-wrapper {
         padding: 0;
         }
         .input-group-append > .form-control-color {
         border-top-left-radius: 0;
         border-bottom-left-radius: 0;
         }
    </style>
    <style>
        [v-cloak] {
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
         }
      </style>

      <script>
      /*(function () {
         const url = new URL(location)
         const livereload = new URL('https://cdn.jsdelivr.net/npm/livereload-js@3/dist/livereload.js?snipver=1')
         livereload.searchParams.set('host', url.hostname)
         if (url.protocol === 'https:') {
           livereload.searchParams.set('port', url.port || 8443)
           livereload.searchParams.set('https', 1)
         } else {
           livereload.searchParams.set('port', url.port || 8086)
         }
         document.write(`<script src="${livereload.href}"></` + 'script>')
         })()*/
      </script>
      <script async src="https://www.googletagmanager.com/gtag/js?id=G-GZZ1VHK5ZD">
      </script>
      <script>;(() => {
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
         })()
      </script>

      @verbatim
      <div class="container my-4" id="app" v-cloak>
      <input type="hidden" id="vcard-no" name="vcard-no" required  v-model="cardno"> 
      <input class="form-control " id="vcard-title" name="vcard-title" type="text" placeholder="為你的大作取個名字吧？" required  v-model="subject">
         <div class="card my-2">
            <div class="card-header">
               <ul class="nav nav-tabs card-header-tabs">
                  <li class="nav-item"><button class="nav-link" type="button" @click="vcard.page = 'setting'" :class="{active: (vcard.page === 'setting')}">設定</button></li>
                  <li class="nav-item" v-for="cardIdx in cardsLen"><button class="nav-link" type="button" @click="vcard.page = cardIdx-1" :class="{active: (vcard.page === cardIdx-1)}">{{ circleNum[cardIdx-1] }}</button></li>
                  <li class="nav-item" v-if="cardsLen &lt; 12"><button class="nav-link" type="button" @click="btnNewCard"><i class="fa fa-plus-circle"></i> 新卡片</button></li>
               </ul>
            </div>
            <div class="card-body" v-if="vcard.page === 'setting'">
               <div class="form-group was-validated mb-2"><label for="vcard-altText">替代文字</label><input class="form-control form-control-sm" id="vcard-altText" type="text" required pattern=".+" v-model="vcard.json5.altText"><small class="form-text text-muted">請填寫在訊息無法顯示時（如：系統通知）的替代文字。</small></div>
               <div class="form-group was-validated mb-2"><label for="vcard-ratio">圖片的長寬比</label><input class="form-control form-control-sm" id="vcard-ratio" type="text" required pattern="\d+:\d+" v-model="vcard.json5.ratio"><small class="form-text text-muted">請填寫卡片圖片的長寬比。</small></div>
               <div class="form-group was-validated mb-2">
                  <label for="vcard-titleSize">標題文字大小</label>
                  <div class="input-group input-group-sm">
                     <input class="form-control form-control-sm" id="vcard-titleSize" type="text" required pattern="[0-9a-zA-Z]+" v-model="vcard.json5.titleSize">
                     <div class="input-group-append">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">請選擇文字大小</button>
                        <div class="dropdown-menu py-0"><button class="dropdown-item" type="button" v-for="fontSize in fontSizes" @click="vcard.json5.titleSize = fontSize" :class="{active: (vcard.json5.titleSize === fontSize)}">{{ fontSize }}</button></div>
                     </div>
                  </div>
                  <small class="form-text text-muted">請填寫卡片標題的文字大小。</small>
               </div>
               <div class="form-group was-validated mb-2">
                  <label for="vcard-descSize">說明文字大小</label>
                  <div class="input-group input-group-sm">
                     <input class="form-control form-control-sm" id="vcard-descSize" type="text" required pattern="[0-9a-zA-Z]+" v-model="vcard.json5.descSize">
                     <div class="input-group-append">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">請選擇文字大小</button>
                        <div class="dropdown-menu py-0"><button class="dropdown-item" type="button" v-for="fontSize in fontSizes" @click="vcard.json5.descSize = fontSize" :class="{active: (vcard.json5.descSize === fontSize)}">{{ fontSize }}</button></div>
                     </div>
                  </div>
                  <small class="form-text text-muted">請填寫卡片說明的文字大小。</small>
               </div>
               <div class="form-group mb-0">
                  <label for="vcard-btnHeight">按鈕大小</label>
                  <select class="form-control form-control-sm" id="vcard-btnHeight" v-model="vcard.json5.btnHeight">
                     <option v-for="btnHeight in btnHeights" :value="btnHeight">{{ btnHeight }}</option>
                  </select>
                  <small class="form-text text-muted">請選擇卡片下方的按鈕大小。</small>
               </div>
            </div>
            <template v-if="curCard">
               <div class="card-body pt-3 pb-2">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group was-validated mb-2"><label for="vcard-title">卡片標題</label><input class="form-control form-control-sm" id="vcard-title" type="text" required pattern=".+" v-model="curCard.title"><small class="form-text text-muted">請填寫卡片標題。</small></div>
                        <div class="form-group was-validated mb-2">
                           <label for="vcard-titleColor">標題文字顏色</label>
                           <div class="input-group input-group-sm">
                              <input class="form-control" id="vcard-titleColor" type="text" inputmode="url" required pattern="#[0-9a-fA-F]{6}" v-model="curCard.titleColor">
                              <div class="input-group-append"><input class="form-control form-control-color" type="color" v-model="curCard.titleColor"></div>
                           </div>
                           <small class="form-text text-muted">請填寫卡片標題文字的顏色。</small>
                        </div>
                        <div class="form-group was-validated mb-2"><label for="vcard-desc">卡片說明</label><textarea class="form-control form-control-sm" id="vcard-desc" required pattern=".+" v-model="curCard.desc"></textarea><small class="form-text text-muted">請填寫卡片說明。</small></div>
                        <div class="form-group was-validated mb-2">
                           <label for="vcard-descColor">說明文字顏色</label>
                           <div class="input-group input-group-sm">
                              <input class="form-control" id="vcard-descColor" type="text" inputmode="url" required pattern="#[0-9a-fA-F]{6}" v-model="curCard.descColor">
                              <div class="input-group-append"><input class="form-control form-control-color" type="color" v-model="curCard.descColor"></div>
                           </div>
                           <small class="form-text text-muted">請填寫卡片說明文字的顏色。</small>
                        </div>
                        <div class="form-group was-validated mb-2"><label for="vcard-link">卡片連結</label><input class="form-control form-control-sm" id="vcard-link" type="url" inputmode="url" required pattern="(https?://|line://|tel:|mailto:)\S+" v-model.trim="curCard.link"><small class="form-text text-muted">你可以使用 <code>?openExternalBrowser=1</code> 另開瀏覽器，如果需要加上再次分享連結，請用能修改的短網址服務 <a target="_blank" href="https://app.lihi.io/admin/login">(如: Lihi)</a>。</small></div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group mb-2 mb-2">
                           <label>控制卡片</label>
                           <div class="btn-group d-flex mb-1"><button class="btn btn-sm btn-outline-info" type="button" @click="btnMoveCard(-1)"><i class="fa fa-arrow-left"></i> 前移</button><button class="btn btn-sm btn-outline-info" type="button" @click="btnMoveCard(1)"><i class="fa fa-arrow-right"></i> 後移</button><button class="btn btn-sm btn-outline-danger" type="button" @click="btnDelCard"><i class="fa fa-trash"></i> 刪除</button></div>
                           <small class="form-text text-muted">你可以點選前後移按鈕來移動卡片。</small>
                        </div>
                        <div class="form-group was-validated mb-2">
                           <label for="vcard-bgColor">卡片底色</label>
                           <div class="input-group input-group-sm">
                              <input class="form-control" id="vcard-bgColor" type="text" inputmode="url" required pattern="#[0-9a-fA-F]{6}" v-model="curCard.bgColor">
                              <div class="input-group-append"><input class="form-control form-control-color" type="color" v-model="curCard.bgColor"></div>
                           </div>
                           <small class="form-text text-muted">請填寫卡片的底色。</small>
                        </div>
                        <div class="form-group was-validated mb-2"><label for="vcard-image">卡片圖片網址 (長寬比 <code>{{ vcard.json5.ratio }}</code>)</label><input class="form-control form-control-sm" id="vcard-image" type="url" inputmode="url" required pattern="https://\S+" v-model.trim="curCard.image"><small class="form-text text-muted">請填寫卡片圖片網址，必須是 <code>https://</code> 開頭，建議可將圖片<a target="_blank" href="https://imgur.com/">上傳到 Imgur 圖床</a>。</small><a class="d-block mt-2" v-if="curCardImgPreview" target="_blank" :href="curCardImgPreview"><img :src="curCardImgPreview" :key="curCardImgPreview" style="width: 100%; max-width: 200px"></a></div>
                     </div>
                  </div>
               </div>
               <ul class="list-group list-group-flush">
                  <li class="list-group-item pt-3 pb-2" v-for="btn, btnIdx in curCard.btns" :key="btnIdx">
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group was-validated mb-2"><label :for="`cardbtn-text-${btnIdx}`">按鈕 {{ circleNum[btnIdx] }} 文字</label><input class="form-control form-control-sm" :id="`cardbtn-text-${btnIdx}`" type="text" required pattern=".+" v-model="btn.text"></div>
                           <div class="form-group was-validated mb-2"><label :for="`cardbtn-link-${btnIdx}`">按鈕 {{ circleNum[btnIdx] }} 連結</label><input class="form-control form-control-sm" :id="`cardbtn-link-${btnIdx}`" type="url" inputmode="url" required pattern="(https?://|line://|tel:|mailto:)\S+" v-model.trim="btn.link"></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group mb-2">
                              <label>控制按鈕 {{ circleNum[btnIdx] }}</label>
                              <div class="btn-group d-flex mb-1"><button class="btn btn-sm btn-outline-info" type="button" @click="arrMove(curCard.btns, btnIdx, btnIdx-1)"><i class="fa fa-arrow-up"></i> 上移</button><button class="btn btn-sm btn-outline-info" type="button" @click="arrMove(curCard.btns, btnIdx, btnIdx+1)"><i class="fa fa-arrow-down"></i> 下移</button><button class="btn btn-sm btn-outline-danger" type="button" @click="btnDelBtn(btnIdx)"><i class="fa fa-trash"></i> 刪除</button></div>
                           </div>
                           <div class="form-group was-validated mb-2">
                              <label :for="`cardbtn-color-${btnIdx}`">按鈕 {{ circleNum[btnIdx] }} 樣式及顏色</label>
                              <div class="input-group input-group-sm">
                                 <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">{{ btnStyles[btn.style] }}</button>
                                    <div class="dropdown-menu py-0"><button class="dropdown-item" type="button" v-for="btnStyleName, btnStyle in btnStyles" @click="btn.style = btnStyle" :class="{active: (btn.style === btnStyle)}">{{ btnStyleName }}</button></div>
                                 </div>
                                 <input class="form-control" :id="`cardbtn-color-${btnIdx}`" type="text" inputmode="url" required pattern="#[0-9a-fA-F]{6}" v-model="btn.color">
                                 <div class="input-group-append"><input class="form-control form-control-color" type="color" v-model="btn.color"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="list-group-item" v-if="curCard.btns.length &lt; 4"><button class="btn btn-outline-success" type="button" @click="btnNewBtn"><i class="fa fa-plus-circle"></i> 新按鈕</button></li>
               </ul>
            </template>
         </div>
         <div class="row mx-n2 my-2 d-flex">
          <button class="btn btn-danger flex-fill mx-2 my-1" type="button" @click="btnReset">
            <i class="fa mr-2 fa-repeat"></i> 重設</button>
          <button class="btn btn-info flex-fill mx-2 my-1" type="button" @click="btnExport">
            <i class="fa mr-2 fa-floppy-disk"></i> 存檔</button>
            <a class="btn btn-primary flex-fill mx-2 my-1" :href="shortcut" target="_blank">
              <i class="fa mr-2 fa-share"></i> 分享</a>
            </div>
         <div class="modal fade" id="modal-exportimport" data-backdrop="static" data-keyboard="false" tabindex="-1" ref="modalExportImport">
            <div class="modal-dialog modal-dialog-centered modal-xl align-items-stretch">
               <div class="modal-content">
                  <div class="modal-body d-flex flex-column">
                    <textarea class="form-control form-control-sm flex-fill" v-model="exportimport.text"></textarea>
                    <small class="text-muted form-text">如果要儲存你現在的設計, 請點一下存檔, 若想複製你設計的原始碼, 也可以點一下複製。</small>
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-outline-success" type="button" @click="btnCopy(exportimport.text, $refs['modalExportImport'])">複製</button>
                    <button class="btn btn-secondary" type="button" @click="jqModal('modalExportImport', 'hide')">取消</button>
                    <button class="btn btn-primary" type="button" @click="btnImport">存檔</button></div>
               </div>
            </div>
         </div>
      </div>
      @endverbatim

      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/crypto-js@3/crypto-js.min.js"></script>
      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/js-base64@3/base64.min.js"></script>
      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/json5@2/dist/index.min.js"></script>
      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/lodash@4/lodash.min.js"></script>
      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/pako@2/dist/pako.min.js"></script>
      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/papaparse@5/papaparse.min.js"></script>
      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/popper.js@1/dist/umd/popper.min.js"></script>
      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/qs@6/dist/qs.min.js"></script>
      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.min.js"></script>
      <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/js/bootstrap.min.js"></script>
      <script src="{{ asset('/js/common.js') }}"></script>


                   
      <script>
        var __serv_template="{{route('line.template.get')}}";
        var __serv_card="{{route('line.cards.get')}}";
        var __serv_card_save="{{route('line.card.store')}}";
        var __serv_user= "{{ Auth::user()->name }}";
      </script>

      @verbatim  
      <script>
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
             async onloadVcard () {
              //get card number
              let cardno= this.paramBase64url('cardno')
              if(!cardno){
                //new card
                let template = this.paramBase64url('template')
                if (!template) template=''

                let type = this.paramBase64url('type')
                if (!type) type=''

                let result = JSON5.parse(_.get(await axios.get(__serv_template, {
                  params: { cachebust: Date.now(), template: template ,type: type},
                  transformResponse: [],
                }), 'data'))

                if(result.is_done=='T'){
                  let sample=JSON5.parse(result.data.sample)
                  const d = new Date()
                  let timestr=__serv_user+" 新增時間："+d.getFullYear()+(d.getMonth()+1)+d.getDate()+d.getHours()+d.getMinutes()
                  this.$set(this, 'vcard', { ...this.vcard, ...sample })
                  this.$set(this, 'cardno', 0)
                  this.$set(this, 'subject', timestr)   
                  this.$set(this, 'template', this.paramBase64url('template'))
                  this.$set(this, 'type', this.paramBase64url('type'))
                  this.$set(this, 'link', result.data.link)
                }

              }else{
                //edit card
                let result = JSON5.parse(_.get(await axios.get(__serv_card, {
                  params: { cachebust: Date.now(), cardno: cardno},
                  transformResponse: [],
                }), 'data'))

                if(result.is_done=='T'){
                  this.$set(this, 'vcard', { ...this.vcard, ...result.data })
                  this.$set(this, 'cardno', { ...this.cardno, ...result.cardno })
                  this.$set(this, 'subject', { ...this.subject, ...result.vcardsubject })
                  this.$set(this, 'template', this.paramBase64url('template'))
                  this.$set(this, 'type', this.paramBase64url('type'))
                }
              }
             }, // abstract
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
             async importVcard () {
              let exported = await this.exportVcard()
              //save card
               let result = JSON5.parse(JSON5.stringify(_.get(await axios.post(__serv_card_save, {
                  params: { cachebust: Date.now(), subject: this.subject , cardno: this.cardno, template: this.template ,type: this.type, exports: exported},
                  transformResponse: [],
                }), 'data')));

                if(result.is_done=='T'){
                  this.$set(this, 'cardno', result.cardno)
                  await Swal.fire({ icon: 'success', title: '存檔成功' })
                }else{
                  await Swal.fire({ icon: 'error', title: '發生異常' })
                }  
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
                 console.log(exported)

                 await Promise.all([
                 this.getTpl()
               ])
/*
                 this.sample = this.getRenderedMsgs()
                 console.log(this.sample)*/
                 this.jqModal('modalExportImport', 'show')
               } catch (err) {
                 window.logError({ err, fatal: true })
                 await Swal.fire({ icon: 'error', title: '匯出失敗', text: err.message })
               }
             },
             async btnImport () {
               try {
                 this.jqModal('modalExportImport', 'hide')
                 await this.importVcard()
                 this.exportimport.text = ''
               } catch (err) {
                 window.logError({ err })
                 await Swal.fire({ icon: 'error', title: '存檔失敗', text: err.message })
               }
             },
             jqModal (ref, action) {
               window.jQuery(this.$refs[ref]).modal(action)
             },
             paramBase64url (key) {
                const base64 = window.getSearchParam(key)
              return base64 ? window.decodeBase64url(base64) : null
            }, 
            async getTpl () {
             
                 const render = _.template(_.get(await axios.get(__serv_template, {
                   params: { cachebust: Date.now() },
                   transformResponse: [],
                 }), 'data'))

                 if (!_.isFunction(render)) throw new Error('')
                 const liffLink = ""
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

               
             },
             getRenderedMsgs () {
               let msg = this.render({ vcard: this.vcard })
               msg = JSON5.parse(msg)
               if (_.includes(['bubble', 'carousel'], _.get(msg, 'type'))) {
                 msg = { type: 'flex', altText: this.$t('flexAltText'), contents: msg }
               }
               msg = _.castArray(msg)
               return msg
             }
           },
         }

      </script>
      @endverbatim

      @verbatim
      <script>
         const cfg = window.vueConfig
         cfg.data = {
           ...cfg.data,
           btnHeights: ['sm', 'md'],
           btnStyles: { link: '文字有指定顏色', primary: '白字與指定底色', secondary: '黑字與指定底色' },
           circleNum: '①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳', // https://www.unicode.org/charts/nameslist/n_2460.html
           fontSizes: ['xxs', 'xs', 'sm', 'md', 'lg', 'xl', 'xxl', '3xl', '4xl', '5xl'],
           cardno:0,
           template:0,
           type:0,
           subject:"",
           link:"",
           sample:null,
           render: null,
           vcard: {
             page: 'setting',
             json5: {
               altText: '請在手機上查看這個訊息',
               btnHeight: 'sm',
               descSize: 'xs',
               ratio: '20:13',
               titleSize: 'xl',
               cards: [
                 {
                   bgColor: '#ffffff',
                   desc: '卡片的敘述',
                   descColor: '#000000',
                   image: 'https://i.imgur.com/n8WZErs.jpg',
                   link: 'http://liuchien.ink.tw/',
                   title: '這是多卡片輪播的模板',
                   titleColor: '#000000',
                   btns: [
                     {
                       color: '#17c950',
                       link: 'http://liuchien.ink.tw/',
                       style: 'primary',
                       text: '按鈕一',
                     },
                     {
                       color: '#42659a',
                       link: 'http://liuchien.ink.tw/',
                       style: 'link',
                       text: '按鈕二',
                     },
                   ],
                 }
               ],
             },
           },
         }

         cfg.computed = {
           ...cfg.computed,
           shortcut () {
             const params = window.httpBuildQuery({
                template: window.encodeBase64url(this.link),
                json5gzip: window.encodeGzip(JSON5.stringify(window.beautifyFlex(this.vcard.json5))),
             })
             if (!_.isString(params) || !params.length) return
             return `https://liff.line.me/1661414135-95aMGZzm/share-json5gzip?${params}`
           },
           curCard () {
             return _.get(this, ['vcard', 'json5', 'cards', this.vcard.page])
           },
           curCardImgPreview () {
             try {
               const url = new URL(this.curCard.image)
               return url.href
             } catch (err) {
               window.logError({ err })
             }
           },
           cardsLen () {
             return _.get(this, 'vcard.json5.cards.length', 0)
           },
         }


         cfg.methods = {
           ...cfg.methods,
           async btnNewCard () {
             if (!_.hasIn(this, 'vcard.json5.cards')) await this.btnReset(false)
             const cards = this.vcard.json5.cards
             cards.push({
               image: '',
               link: 'https://taichunmin.idv.tw/liff-businesscard/',
               desc: '',
               title: '',
               btns: [{
                 color: '#ffffff',
                 link: 'https://taichunmin.idv.tw/liff-businesscard/',
                 text: '',
                 style: 'primary',
               }],
             })
             this.vcard.page = cards.length - 1
           },
           async btnNewBtn () {
             const btns = _.get(this, 'curCard.btns')
             if (!_.isArray(btns)) return
             btns.push({
               color: '#ffffff',
               link: 'https://taichunmin.idv.tw/liff-businesscard/',
               text: '分享給好友',
               style: 'primary',
             })
           },
           btnMoveCard (offset) {
             const arr = this.vcard.json5.cards
             const oldIdx = _.toSafeInteger(this.vcard.page)
             let newIdx = (oldIdx + offset) % arr.length
             newIdx += (newIdx < 0 ? arr.length : 0)
             this.arrMove(arr, oldIdx, newIdx)
             this.vcard.page = newIdx
           },
           async btnDelCard () {
             const idx = _.toSafeInteger(this.vcard.page)
             const arr = _.get(this, 'vcard.json5.cards')
             if (!_.isArray(arr)) return
             const yn = await Swal.fire({
               cancelButtonColor: '#3085d6',
               cancelButtonText: '取消',
               confirmButtonColor: '#d33',
               confirmButtonText: '刪除',
               focusCancel: true,
               icon: 'warning',
               showCancelButton: true,
               text: `是否刪除卡片 ${this.circleNum[idx]}？`,
             })
             if (!yn.value) return
             arr.splice(idx, 1)
             this.vcard.page = 'setting'
           },
           async btnDelBtn (idx) {
             const arr = _.get(this, 'curCard.btns')
             if (!_.isArray(arr)) return
             const yn = await Swal.fire({
               cancelButtonColor: '#3085d6',
               cancelButtonText: '取消',
               confirmButtonColor: '#d33',
               confirmButtonText: '刪除',
               focusCancel: true,
               icon: 'warning',
               showCancelButton: true,
               text: `是否刪除按鈕 ${this.circleNum[idx]}？`,
             })
             if (!yn.value) return
             arr.splice(idx, 1)
           },
           arrMove (arr, oldIdx, newIdx) {
             const len = _.get(arr, 'length', 0)
             if (!len || !_.inRange(oldIdx, len)) return
             newIdx %= len
             newIdx += (newIdx < 0 ? len : 0)
             arr.splice(newIdx, 0, ...arr.splice(oldIdx, 1))
           },
         }
         @endverbatim  
      </script>
     
      
      <script>
        @verbatim
         (async () => {
           if (_.isFunction(window.beforeVueCreate)) await window.beforeVueCreate()
           window.vm = new Vue(window.vueConfig)
         })()
         @endverbatim
      </script>

</x-app-layout>
