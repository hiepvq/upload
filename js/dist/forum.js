(()=>{var t={n:e=>{var i=e&&e.__esModule?()=>e.default:()=>e;return t.d(i,{a:i}),i},d:(e,i)=>{for(var o in i)t.o(i,o)&&!t.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:i[o]})},o:(t,e)=>Object.prototype.hasOwnProperty.call(t,e),r:t=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})}},e={};(()=>{"use strict";t.r(e),t.d(e,{components:()=>X});const i=flarum.core.compat["common/extend"],o=flarum.core.compat["forum/app"];var a=t.n(o);const s=flarum.core.compat["forum/components/UserPage"];var n=t.n(s);const r=flarum.core.compat["common/components/LinkButton"];var l=t.n(r);function u(t,e){return u=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t},u(t,e)}function d(t,e){t.prototype=Object.create(e.prototype),t.prototype.constructor=t,u(t,e)}const p=flarum.core.compat["common/Model"];var c=t.n(p);const f=flarum.core.compat["common/utils/mixin"];var h=function(t){function e(){return t.apply(this,arguments)||this}return d(e,t),e.prototype.apiEndpoint=function(){return"/fof/uploads"+(this.exists?"/"+this.data.id:"")},e}(t.n(f)()(c(),{baseName:c().attribute("baseName"),path:c().attribute("path"),url:c().attribute("url"),type:c().attribute("type"),size:c().attribute("size"),humanSize:c().attribute("humanSize"),createdAt:c().attribute("createdAt"),uuid:c().attribute("uuid"),tag:c().attribute("tag"),hidden:c().attribute("hidden"),bbcode:c().attribute("bbcode")})),g=function(){function t(){this.user=null,this.files=[],this.moreResults=!1,this.loading=!1}var e=t.prototype;return e.setUser=function(t){t!==this.user&&(this.user=t,this.files=[],this.loadResults())},e.loadResults=function(t){if(void 0===t&&(t=0),this.user)return this.loading=!0,a().store.find("fof/uploads",{filter:{user:this.user.id()},page:{offset:t}}).then(this.parseResults.bind(this))},e.loadMore=function(){this.loading=!0,this.loadResults(this.files.length).then(this.parseResults.bind(this))},e.parseResults=function(t){var e;return(e=this.files).push.apply(e,t),this.loading=!1,this.moreResults=!!t.payload.links&&!!t.payload.links.next,m.redraw(),t},e.addToList=function(t){var e;Array.isArray(t)?(e=this.files).unshift.apply(e,t):this.files.unshift(t)},e.hasFiles=function(){return this.files.length>0},e.isLoading=function(){return this.loading},e.hasMoreResults=function(){return this.moreResults},e.empty=function(){return!this.hasFiles()&&!this.isLoading()},t}();const v=flarum.core.compat["forum/components/Post"];var b=t.n(v);const y=flarum.core.compat["common/components/TextEditor"];var F=t.n(y);const w=flarum.core.compat["common/Component"];var N=t.n(w);const B=flarum.core.compat["common/components/Button"];var _=t.n(B);const M=flarum.core.compat["common/components/LoadingIndicator"];var x=t.n(M);const L=flarum.core.compat["common/utils/classList"];var S=t.n(L);const C=flarum.core.compat["common/components/Tooltip"];var k=t.n(C),O=function(t){function e(){return t.apply(this,arguments)||this}d(e,t);var i=e.prototype;return i.oninit=function(e){var i=this;t.prototype.oninit.call(this,e),this.attrs.uploader.on("uploaded",(function(){i.$("form")[0].reset(),m.redraw()})),this.isMediaUploadButton=e.attrs.isMediaUploadButton||!1},i.view=function(){var t=this.attrs.uploader.uploading?a().translator.trans("fof-upload.forum.states.loading"):a().translator.trans("fof-upload.forum.buttons.upload");return m(k(),{text:t},m(_(),{className:S()(["Button","hasIcon","fof-upload-button",!this.isMediaUploadButton&&!this.attrs.uploader.uploading&&"Button--icon",!this.isMediaUploadButton&&!this.attrs.uploader.uploading&&"Button--link",this.attrs.uploader.uploading&&"uploading"]),icon:!this.attrs.uploader.uploading&&"fas fa-file-upload",onclick:this.uploadButtonClicked.bind(this),disabled:this.attrs.disabled},this.attrs.uploader.uploading&&m(x(),{size:"small",display:"inline",className:"Button-icon"}),(this.isMediaUploadButton||this.attrs.uploader.uploading)&&m("span",{className:"Button-label"},t),m("form",null,m("input",{type:"file",multiple:!0,onchange:this.process.bind(this)}))))},i.process=function(t){var e=this.$("input").prop("files");0!==e.length&&this.attrs.uploader.upload(e,!this.isMediaUploadButton)},i.uploadButtonClicked=function(t){this.$("input").click()},e}(N()),U=function(){function t(t,e){this.upload=t,this.composerElement=e,this.handlers={},this.supportsFileDragging()&&(this.composerElement.addEventListener("dragover",this.handlers.in=this.in.bind(this)),this.composerElement.addEventListener("dragleave",this.handlers.out=this.out.bind(this)),this.composerElement.addEventListener("dragend",this.handlers.out),this.composerElement.addEventListener("drop",this.handlers.dropping=this.dropping.bind(this)))}var e=t.prototype;return e.supportsFileDragging=function(){var t=document.createElement("div");return("draggable"in t||"ondragstart"in t&&"ondrop"in t)&&"FormData"in window&&"FileReader"in window},e.unload=function(){this.handlers.in&&(this.composerElement.removeEventListener("dragover",this.handlers.in),this.composerElement.removeEventListener("dragleave",this.handlers.out),this.composerElement.removeEventListener("dragend",this.handlers.out),this.composerElement.removeEventListener("drop",this.handlers.dropping))},e.isNotFile=function(t){if(t.dataTransfer.items)for(var e=0;e<t.dataTransfer.items.length;e++)if("file"!==t.dataTransfer.items[e].kind)return!0;return!1},e.in=function(t){this.isNotFile(t)||(t.preventDefault(),this.over||(this.composerElement.classList.add("fof-upload-dragging"),this.over=!0))},e.out=function(t){this.isNotFile(t)||(t.preventDefault(),this.over&&(this.composerElement.classList.remove("fof-upload-dragging"),this.over=!1))},e.dropping=function(t){this.isNotFile(t)||(t.preventDefault(),this.upload(t.dataTransfer.files),this.composerElement.classList.remove("fof-upload-dragging"))},t}(),T=function(){function t(t,e){this.upload=t,e.addEventListener("paste",this.paste.bind(this))}return t.prototype.paste=function(t){if(t.clipboardData&&t.clipboardData.items){for(var e=t.clipboardData.items,i=[],o=0;o<e.length;o++)-1!==e[o].type.indexOf("image")&&i.push(e[o].getAsFile());i.length>0&&(t.preventDefault(),this.upload(i))}},t}(),E=function(){function t(){this.callbacks={success:[],failure:[],uploading:[],uploaded:[]},this.uploading=!1}var e=t.prototype;return e.on=function(t,e){this.callbacks[t].push(e)},e.dispatch=function(t,e){this.callbacks[t].forEach((function(t){return t(e)}))},e.upload=function(t,e){var i=this;void 0===e&&(e=!0),this.uploading=!0,this.dispatch("uploading",t),m.redraw();for(var o=new FormData,s=0;s<t.length;s++)o.append("files[]",t[s]);return a().request({method:"POST",url:a().forum.attribute("apiUrl")+"/fof/upload",serialize:function(t){return t},body:o}).then((function(t){return i.uploaded(t,e)})).catch((function(t){i.uploading=!1,m.redraw();var e=t.response.errors[0];if(!e.code.includes("fof-upload"))throw t;a().alerts.clear(),a().alerts.show({type:"error"},e.detail)}))},e.uploaded=function(t,e){var i=this;void 0===e&&(e=!1),this.uploading=!1,t.data.forEach((function(t){var o=a().store.pushObject(t);a().fileListState.addToList(o),i.dispatch("success",{file:o,addBBcode:e})})),this.dispatch("uploaded")},t}();const D=flarum.core.compat["common/components/Modal"];var A=t.n(D);const R=flarum.core.compat["common/components/Alert"];var j=t.n(R);const z=flarum.core.compat["common/utils/extractText"];var P=t.n(z),H=["image/png","image/jpg","image/jpeg","image/svg+xml","image/gif"],I=["application/zip","application/x-7z-compressed","application/gzip","application/vnd.rar","application/x-rar-compressed"],$=["text/html","text/css","text/javascript","application/json","application/ld+json","text/javascript","application/x-httpd-php"],q=["application/x-abiword","application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/pdf"],V=function(t){function e(){return t.apply(this,arguments)||this}d(e,t);var i=e.prototype;return i.oninit=function(e){t.prototype.oninit.call(this,e),a().fileListState.setUser(e.attrs.user||a().session.user),this.inModal=e.attrs.selectable,this.restrictFileType=e.attrs.restrictFileType||null,this.downloadOnClick=this.attrs.downloadOnClick||!1,this.filesBeingHidden=[],this.user=a().fileListState.user},i.view=function(){var t=this,e=a().fileListState;return m("div",{className:"fof-upload-file-list","aria-live":"polite"},e.isLoading()&&0===e.files.length&&m("div",{className:"fof-upload-loading"},a().translator.trans("fof-upload.forum.file_list.loading"),m(x(),null)),this.inModal&&e.empty()&&m("p",{className:"fof-upload-empty"},m("i",{className:"fas fa-cloud-upload-alt fof-upload-empty-icon"}),a().translator.trans("fof-upload.forum.file_list.modal_empty_"+("phone"!==a().screen()?"desktop":"phone"))),!this.inModal&&e.empty()&&m("div",{className:"Placeholder"},m("p",{className:"fof-upload-empty"},a().translator.trans("fof-upload.forum.file_list.empty"))),m("ul",null,e.files.map((function(e){var i,o=(i=e.type(),H.includes(i)?"image":i.includes("image/")?"far fa-file-image":i.includes("video/")?"far fa-file-video":I.indexOf(i)>=0?"far fa-file-archive":"application/pdf"===i?"far fa-file-pdf":q.indexOf(i)>=0?"far fa-file-word":i.includes("audio/")?"far fa-file-audio":$.indexOf(i)>=0?"far fa-file-code":"far fa-file"),s=!t.restrictFileType||t.isSelectable(e),n=S()(["fof-file","image"===o&&"fof-file-type-image",t.attrs.selectedFiles&&t.attrs.selectedFiles.indexOf(e.id())>=0&&"fof-file-selected"]),r=e.baseName(),l=t.filesBeingHidden.includes(e.uuid());return m("li",{"aria-busy":l},a().session.user&&(t.user===a().session.user||a().session.user.deleteOthersMediaLibrary())&&m(_(),{className:"Button Button--icon fof-file-delete",icon:"far fa-trash-alt","aria-label":a().translator.trans("fof-upload.forum.file_list.delete_file_a11y_label",{fileName:r}),disabled:l,onclick:t.hideFile.bind(t,e)}),m("button",{className:n,onclick:function(){return t.onFileClick(e)},disabled:!s||l,"aria-label":P()(a().translator.trans("fof-upload.forum.file_list.select_file_a11y_label",{fileName:r}))},m("figure",null,"image"===o?m("img",{src:e.url(),className:"fof-file-image-preview",draggable:!1,alt:""}):m("span",{className:"fof-file-icon",role:"presentation"},m("i",{className:"fa-fw "+o})),m("figcaption",{className:"fof-file-name"},r),l&&m("span",{class:"fof-file-loading",role:"status","aria-label":a().translator.trans("fof-upload.forum.file_list.hide_file.loading")},m(x(),null)))))}))),e.hasMoreResults()&&m("div",{className:"fof-load-more-files"},m(_(),{className:"Button Button--primary",disabled:e.isLoading(),loading:e.isLoading(),onclick:function(){return e.loadMore()}},a().translator.trans("fof-upload.forum.file_list.load_more_files_btn"))))},i.onFileClick=function(t){this.attrs.onFileSelect?this.attrs.onFileSelect(t):this.attrs.downloadOnClick&&window.open(t.url())},i.isSelectable=function(t){var e=t.type();return Array.isArray(this.restrictFileType)?this.restrictFileType.indexOf(e)>=0:"image"===this.restrictFileType?e.includes("image/"):"audio"===this.restrictFileType?e.includes("audio/"):"video"===this.restrictFileType&&e.includes("video/")},i.hideFile=function(t){var e=this,i=t.uuid();if(!this.filesBeingHidden.includes(i))if(this.filesBeingHidden.push(i),confirm(P()(a().translator.trans("fof-upload.forum.file_list.hide_file.hide_confirmation",{fileName:t.baseName()}))))a().request({method:"PATCH",url:a().forum.attribute("apiUrl")+"/fof/upload/hide",body:{uuid:i}}).then((function(){a().alerts.show(j(),{type:"success"},a().translator.trans("fof-upload.forum.file_list.hide_file.hide_success"))})).catch((function(){a().alerts.show(j(),{type:"error"},a().translator.trans("fof-upload.forum.file_list.hide_file.hide_fail",{fileName:t.fileName()}))})).then((function(){var t=a().fileListState,o=t.files.findIndex((function(t){return i===t.uuid()}));t.files.splice(o,1);var s=e.filesBeingHidden.indexOf(i);e.filesBeingHidden.splice(s,1)}));else{var o=this.filesBeingHidden.indexOf(i);this.filesBeingHidden.splice(o,1)}},e}(N()),G=function(t){function e(){return t.apply(this,arguments)||this}d(e,t);var i=e.prototype;return i.oninit=function(e){t.prototype.oninit.call(this,e),this.uploader=e.attrs.uploader,this.selectedFiles=[],this.multiSelect=e.attrs.multiSelect||!0,this.restrictFileType=e.attrs.restrictFileType||null,this.dragDrop=null,this.onUpload()},i.className=function(){return"Modal--large fof-file-manager-modal"},i.oncreate=function(e){var i=this;t.prototype.oncreate.call(this,e),this.dragDrop=new U((function(t){return i.uploader.upload(t,!1)}),this.$().find(".Modal-content")[0])},i.onremove=function(){this.dragDrop&&this.dragDrop.unload()},i.view=function(){var t=this.selectedFiles.length;return m("div",{className:"Modal modal-dialog "+this.className()},m("div",{className:"Modal-content"},m("div",{className:"fof-modal-buttons App-backControl"},m(O,{uploader:this.uploader,disabled:app.fileListState.isLoading(),isMediaUploadButton:!0})),m("div",{className:"fof-drag-and-drop"},m("div",{className:"fof-drag-and-drop-release"},m("i",{className:"fas fa-cloud-upload-alt"}),app.translator.trans("fof-upload.forum.file_list.release_to_upload"))),m("div",{className:"Modal-header"},m("h3",{className:"App-titleControl App-titleControl--text"},app.translator.trans("fof-upload.forum.media_manager"))),this.alertAttrs&&m("div",{className:"Modal-alert"},m(Alert,this.alertAttrs)),m("div",{className:"Modal-body"},m(V,{user:this.attrs.user,selectable:!0,onFileSelect:this.onFileSelect.bind(this),selectedFiles:this.selectedFiles,restrictFileType:this.restrictFileType})),m("div",{className:"Modal-footer"},m(_(),{onclick:this.hide.bind(this),className:"Button"},app.translator.trans("fof-upload.forum.buttons.cancel")),m(_(),{onclick:this.onSelect.bind(this),disabled:0===this.selectedFiles.length||!this.multiSelect&&this.selectedFiles.length>1,className:"Button Button--primary"},app.translator.trans("fof-upload.forum.file_list.confirm_selection_btn",{fileCount:t})))))},i.onFileSelect=function(t){var e=this.selectedFiles.indexOf(t.id());e>=0?this.selectedFiles.splice(e,1):this.multiSelect?this.selectedFiles.push(t.id()):this.selectedFiles=[t.id()]},i.onUpload=function(){var t=this;this.uploader.on("success",(function(e){var i=e.file;t.multiSelect?t.selectedFiles.push(i.id()):t.selectedFiles=[i.id()]}))},i.onSelect=function(){this.hide(),this.attrs.onSelect?this.attrs.onSelect(this.selectedFiles):this.selectedFiles.map((function(t){var e=app.store.getById("files",t);app.composer.editor.insertAtCursor(e.bbcode()+"\n",!1)}))},e}(A()),J=function(t){function e(){return t.apply(this,arguments)||this}d(e,t);var i=e.prototype;return i.view=function(){return m(k(),{text:a().translator.trans("fof-upload.forum.buttons.media")},_().component({className:"Button fof-upload-button Button--icon",onclick:this.fileManagerButtonClicked.bind(this),icon:"fas fa-photo-video"}))},i.fileManagerButtonClicked=function(t){t.preventDefault(),a().modal.show(G,{uploader:this.attrs.uploader})},e}(N()),K=function(t){function e(){return t.apply(this,arguments)||this}d(e,t);var i=e.prototype;return i.oninit=function(e){t.prototype.oninit.call(this,e),this.user=null,this.loadUser(m.route.param("username"))},i.content=function(){return a().session.user&&(a().session.user.viewOthersMediaLibrary()||this.user===a().session.user)?this.user&&V.component({user:this.user,selectable:!1,downloadOnClick:!0}):null},i.show=function(e){t.prototype.show.call(this,e),this.user=e},e}(n());const Q=flarum.core.compat["common/models/User"];var W=t.n(Q),X={DragAndDrop:U,FileManagerButton:J,FileManagerModal:G,UserFileList:V,Uploader:E,UploadButton:O};a().initializers.add("fof-upload",(function(){W().prototype.viewOthersMediaLibrary=c().attribute("fof-upload-viewOthersMediaLibrary"),W().prototype.deleteOthersMediaLibrary=c().attribute("fof-upload-deleteOthersMediaLibrary"),W().prototype.uploadCountCurrent=c().attribute("fof-upload-uploadCountCurrent"),W().prototype.uploadCountAll=c().attribute("fof-upload-uploadCountAll"),(0,i.extend)(F().prototype,"oninit",(function(){this.uploader=new E})),(0,i.extend)(F().prototype,"controlItems",(function(t){if(a().forum.attribute("fof-upload.canUpload")){var e=a().forum.attribute("fof-upload.composerButtonVisiblity");"both"!==e&&"media-btn"!==e||t.add("fof-upload-media",J.component({uploader:this.uploader})),"both"!==e&&"upload-btn"!==e||t.add("fof-upload",O.component({uploader:this.uploader}))}})),(0,i.extend)(F().prototype,"oncreate",(function(t,e){var i=this;a().forum.attribute("fof-upload.canUpload")&&(this.uploader.on("success",(function(t){var e=t.file;if(t.addBBcode&&(i.attrs.composer.editor.insertAtCursor(e.bbcode()+"\n",!1),"function"==typeof i.attrs.preview)){var o=a().composer.isFullScreen;a().composer.isFullScreen=function(){return!1},i.attrs.preview(),a().composer.isFullScreen=o}})),this.dragAndDrop=new U((function(t){return i.uploader.upload(t)}),this.$().parents(".Composer")[0]),new T((function(t){return i.uploader.upload(t)}),this.$(".TextEditor-editor")[0]))})),(0,i.extend)(F().prototype,"onremove",(function(t,e){a().forum.attribute("fof-upload.canUpload")&&this.dragAndDrop.unload()})),(0,i.extend)(b().prototype,"oncreate",(function(){var t=this;this.$("[data-fof-upload-download-uuid]").unbind("click").on("click",(function(e){if(e.preventDefault(),e.stopPropagation(),a().forum.attribute("fof-upload.canDownload")){var i=a().forum.attribute("apiUrl")+"/fof/download";i+="/"+encodeURIComponent(e.currentTarget.dataset.fofUploadDownloadUuid),i+="/"+encodeURIComponent(t.attrs.post.id()),i+="/"+encodeURIComponent(a().session.csrfToken),window.open(i)}else alert(a().translator.trans("fof-upload.forum.states.unauthorized"))}))})),a().store.models.files=h,a().fileListState=new g,a().routes["user.uploads"]={path:"/u/:username/uploads",component:K},(0,i.extend)(n().prototype,"navItems",(function(t){var e=!!a().forum.attribute("fof-upload.canUpload"),i=!!this.user.uploadCountCurrent();if(a().session.user&&(a().session.user.viewOthersMediaLibrary()||this.user===a().session.user&&(e||i))){var o=this.user.uploadCountCurrent();t.add("uploads",l().component({href:a().route("user.uploads",{username:this.user.username()}),name:"uploads",icon:"fas fa-file-upload"},[this.user===a().session.user?a().translator.trans("fof-upload.forum.buttons.media"):a().translator.trans("fof-upload.forum.buttons.user_uploads")," ",o>0?m("span",{className:"Button-badge"},o):""]),80)}}))}))})(),module.exports=e})();
//# sourceMappingURL=forum.js.map