(window.webpackJsonp=window.webpackJsonp||[]).push([[0,3],{23:function(t,e,n){"use strict";var s=n(5);n.n(s).a},24:function(t,e,n){(t.exports=n(2)(!1)).push([t.i,".chat-app{max-height:400px;min-height:400px;overflow-y:scroll;overflow-x:hidden}.chat-app li{list-style:none;border:1px solid grey;padding:5px;margin-top:5px;word-wrap:break-word}.composer-user{width:25%;position:fixed;bottom:0;right:15px}.admin{background-color:#d33b33;color:#fff;position:-webkit-sticky;position:sticky;top:0;z-index:1;border:1px solid grey}.admin h5{color:#fff;margin-top:10px}",""])},25:function(t,e,n){"use strict";n.r(e);var s={props:{user:{type:Object,required:!0}},data:function(){return{message:"",messages:[],admin:{type:Object}}},methods:{startConversation:function(t){var e=this;t.preventDefault(),""!=this.message&&(axios.post("/admin/conversation/send",{contact_id:this.admin.id,text:this.message}).then((function(t){e.saveNewMessage(t.data)})),this.message="")},saveNewMessage:function(t){this.messages.push(t)},handleIncoming:function(t){t.from!=this.admin.id||this.saveNewMessage(t)},scrollToBottom:function(){var t=this;setTimeout((function(){var e=t.$refs.feed;e.scrollTop=e.scrollHeight}),50)}},watch:{messages:function(t){this.scrollToBottom()}},mounted:function(){var t=this;this.scrollToBottom(),window.Echo.private("messages.".concat(this.user.id)).listen("MessageSentEvent",(function(e){t.handleIncoming(e.message)})),axios.get("/chat/onlineadmin").then((function(e){t.admin=e.data[0],axios.get("/admin/conversation/".concat(t.admin.id)).then((function(e){t.messages=e.data}))}))}},a=(n(23),n(0)),i=Object(a.a)(s,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{ref:"feed",staticClass:"chat-app"},[n("div",{staticClass:"admin"},[n("h5",[t._v("Chat with "+t._s(t.admin.name)+" ")])]),t._v(" "),n("div",[t.admin?n("ul",t._l(t.messages,(function(e){return n("li",{key:e.id,class:"message"+(e.to==t.admin.id?"send":"reseved")},[n("div",{staticClass:"text"},[t._v("\n                "+t._s(e.text)+"\n            ")])])})),0):t._e(),t._v(" "),n("div",{staticClass:"composer-user"},[n("textarea",{directives:[{name:"model",rawName:"v-model",value:t.message,expression:"message"}],attrs:{placeholder:"Message..."},domProps:{value:t.message},on:{keydown:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.startConversation(e)},input:function(e){e.target.composing||(t.message=e.target.value)}}})])])])}),[],!1,null,null,null);e.default=i.exports},5:function(t,e,n){var s=n(24);"string"==typeof s&&(s=[[t.i,s,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};n(3)(s,a);s.locals&&(t.exports=s.locals)},67:function(t,e,n){"use strict";n.r(e);n(25);var s={props:{user:{type:Object,required:!0}},data:function(){return{unread_count:null,admin:{type:Object}}},methods:{openchat:function(){var t=this;axios.put("/admin/conversation/update/".concat(this.admin.id,"/").concat(this.user.id)).then((function(e){t.unread_count=null})),this.$emit("showchat")}},watch:{},mounted:function(){var t=this;window.Echo.private("messages.".concat(this.user.id)).listen("MessageSentEvent",(function(e){t.unread_count++})),axios.get("/chat/unreadcount/".concat(this.user.id)).then((function(e){t.unread_count=e.data})),axios.get("/chat/onlineadmin").then((function(e){t.admin=e.data[0]}))}},a=n(0),i=Object(a.a)(s,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"chat",on:{click:t.openchat}},[t.unread_count?n("span",{staticClass:"unread"},[t._v(t._s(0==t.unread_count?"":t.unread_count))]):t._e(),t._v(" "),n("i",{staticClass:"fas fa-comment"})])}),[],!1,null,null,null);e.default=i.exports}}]);