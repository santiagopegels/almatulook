(window.webpackJsonp=window.webpackJsonp||[]).push([[5],{"4vZB":function(e,t,r){"use strict";r.r(t);var a=r("o0o1"),s=r.n(a),n=r("L2JU"),o=r("ta7f");function c(e,t,r,a,s,n,o){try{var c=e[n](o),i=c.value}catch(e){return void r(e)}c.done?t(i):Promise.resolve(i).then(a,s)}function i(e){return function(){var t=this,r=arguments;return new Promise((function(a,s){var n=e.apply(t,r);function o(e){c(n,a,s,o,i,"next",e)}function i(e){c(n,a,s,o,i,"throw",e)}o(void 0)}))}}function d(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(e);t&&(a=a.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,a)}return r}function u(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?d(Object(r),!0).forEach((function(t){l(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):d(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function l(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}var p={props:{},data:function(){return{submitted:!1,model:"status_orders",model_name:"estado"}},validations:function(){return this.hasSelectedId()?{selected_order_status:{id:{required:o.required,integer:o.integer},status:{minLength:Object(o.minLength)(2)},order:{integer:o.integer}}}:{selected_order_status:{status:{minLength:Object(o.minLength)(2)},order:{integer:o.integer}}}},created:function(){},mounted:function(){},computed:u(u({},Object(n.b)(["isLoading","selected_order_status","page"])),{},{hasId:function(){return Boolean(this.hasSelectedId())},getTitle:function(){return this.hasSelectedId()?"Editar estado":"Crear nuevo estado"},buttonText:function(){return this.hasSelectedId()?"Actualizar estado":"Crear estado"}}),methods:{hasSelectedId:function(){return!!Boolean(this.selected_order_status)&&Boolean(this.selected_order_status.id>0)},handleSubmit:function(e){if(e.preventDefault(),this.submitted=!0,this.$v.$touch(),!this.$v.$invalid)return this.hasSelectedId()?this.update():this.store()},store:function(){var e=this;return i(s.a.mark((function t(){return s.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.$store.dispatch("store",{model:e.model,data:{status:e.selected_order_status.status,order:e.selected_order_status.order,can_delete_order:e.selected_order_status.can_delete_order}}).then(function(){var t=i(s.a.mark((function t(r){return s.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e.$v.$reset(),e.$toasted.global.ToastedSuccess({message:"El ".concat(e.model_name," fue creado!")}),t.next=4,e.fetch();case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}()).catch((function(t){return e.$toasted.global.ToastedError({message:t.message.message})}));case 2:case"end":return t.stop()}}),t)})))()},update:function(){var e=this;return i(s.a.mark((function t(){return s.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.$store.dispatch("update",{model:e.model,data:{_method:"PUT",id:e.selected_order_status.id,status:e.selected_order_status.status,order:e.selected_order_status.order,can_delete_order:e.selected_order_status.can_delete_order}}).then(function(){var t=i(s.a.mark((function t(r){return s.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e.$v.$reset(),e.$toasted.global.ToastedSuccess({message:"El ".concat(e.model_name," fue actualizado!")}),t.next=4,e.fetch();case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}()).catch((function(t){return e.$toasted.global.ToastedError({message:t.message.message})}));case 2:case"end":return t.stop()}}),t)})))()},fetch:function(){var e=this;return i(s.a.mark((function t(){return s.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.$store.dispatch("fetch",{model:e.model,page:e.page}).catch((function(t){return e.$toasted.global.ToastedError({message:t.message.message})}));case 2:case"end":return t.stop()}}),t)})))()},cancelOrderStatus:function(){var e=this;return i(s.a.mark((function t(){return s.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e.$store.commit("SET_SELECTED_ORDER_STATUS"),e.$v.$reset();case 2:case"end":return t.stop()}}),t)})))()}}},f=r("KHd+"),_=Object(f.a)(p,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{class:{"card card-accent-warning":e.hasId,"card card-accent-primary":!e.hasId}},[r("div",{staticClass:"card-header"},[r("i",{staticClass:"icon-user-follow",class:{"icon-settings":e.hasId,"icon-plus":!e.hasId}}),e._v("\n            "+e._s(e.getTitle)+"\n            "),r("span",{staticClass:"float-right"},[e.hasId?r("span",{staticClass:"badge badge-warning"},[e._v("\n\t\t\t\t\tID\n\t\t\t\t\t"),r("strong",[e._v(e._s(e.selected_order_status.id))])]):e._e(),e._v(" "),e.hasId?r("span",{staticClass:"ml-1"},[r("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"alert","aria-label":"Close"},on:{click:function(t){return e.cancelOrderStatus()}}},[r("span",{attrs:{"aria-hidden":"true"}},[e._v("×")])])]):e._e()])]),e._v(" "),r("div",{staticClass:"card-body"},[r("form",{attrs:{method:"POST","accept-charset":"UTF-8"},on:{submit:e.handleSubmit}},[r("div",{staticClass:"form-group"},[r("label",{attrs:{for:"status"}},[e._v("Estado")]),e._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:e.selected_order_status.status,expression:"selected_order_status.status"},{name:"capitalize",rawName:"v-capitalize"}],staticClass:"form-control",class:{"is-invalid":e.submitted&&e.$v.selected_order_status.status.$error},attrs:{type:"text",id:"status",name:"status"},domProps:{value:e.selected_order_status.status},on:{input:function(t){t.target.composing||e.$set(e.selected_order_status,"status",t.target.value)}}}),e._v(" "),e.submitted&&!e.$v.selected_order_status.status.required?r("div",{staticClass:"invalid-feedback"},[e._v("El nombre del estado es requerido.\n                    ")]):e._e()]),e._v(" "),r("div",{staticClass:"form-group"},[r("label",{attrs:{for:"order"}},[e._v("Orden")]),e._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:e.selected_order_status.order,expression:"selected_order_status.order"},{name:"capitalize",rawName:"v-capitalize"}],staticClass:"form-control",class:{"is-invalid":e.submitted&&e.$v.selected_order_status.order.$error},attrs:{type:"number",id:"order",name:"order"},domProps:{value:e.selected_order_status.order},on:{input:function(t){t.target.composing||e.$set(e.selected_order_status,"order",t.target.value)}}})]),e._v(" "),r("div",{staticClass:"form-check"},[r("input",{directives:[{name:"model",rawName:"v-model",value:e.selected_order_status.can_delete_order,expression:"selected_order_status.can_delete_order"},{name:"capitalize",rawName:"v-capitalize"}],staticClass:"form-check-input",class:{"is-invalid":e.submitted&&e.$v.selected_order_status.can_delete_order.$error},attrs:{type:"checkbox",id:"deleteOrder",name:"deleteOrder"},domProps:{checked:Array.isArray(e.selected_order_status.can_delete_order)?e._i(e.selected_order_status.can_delete_order,null)>-1:e.selected_order_status.can_delete_order},on:{change:function(t){var r=e.selected_order_status.can_delete_order,a=t.target,s=!!a.checked;if(Array.isArray(r)){var n=e._i(r,null);a.checked?n<0&&e.$set(e.selected_order_status,"can_delete_order",r.concat([null])):n>-1&&e.$set(e.selected_order_status,"can_delete_order",r.slice(0,n).concat(r.slice(n+1)))}else e.$set(e.selected_order_status,"can_delete_order",s)}}}),e._v(" "),r("label",{attrs:{for:"deleteOrder"}},[e._v("Borra orden de compra")])]),e._v(" "),r("div",{staticClass:"form-group"},[r("div",[r("button",{class:{invalid:e.$v.$invalid,"btn btn-warning btn-block":e.hasId,"btn btn-success btn-block":!e.hasId},attrs:{type:"submit"}},[e._v(e._s(e.buttonText)+"\n                        ")]),e._v(" "),r("button",{staticClass:"btn btn-secondary btn-block",attrs:{type:"button"},on:{click:function(t){return e.cancelOrderStatus()}}},[e._v("Cancelar\n                        ")])])])])])])}),[],!1,null,null,null);t.default=_.exports},U5Zl:function(e,t,r){"use strict";r.r(t);var a=r("o0o1"),s=r.n(a),n=r("L2JU"),o=r("kGIl"),c=r.n(o),i=(r("5A0h"),r("LvDl"));function d(e,t,r,a,s,n,o){try{var c=e[n](o),i=c.value}catch(e){return void r(e)}c.done?t(i):Promise.resolve(i).then(a,s)}function u(e){return function(){var t=this,r=arguments;return new Promise((function(a,s){var n=e.apply(t,r);function o(e){d(n,a,s,o,c,"next",e)}function c(e){d(n,a,s,o,c,"throw",e)}o(void 0)}))}}function l(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(e);t&&(a=a.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,a)}return r}function p(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?l(Object(r),!0).forEach((function(t){f(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):l(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function f(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}var _={props:{},data:function(){return{opacity:.3,model:"status_orders",model_name:"estado"}},created:function(){},mounted:function(){this.fetch()},computed:p(p({},Object(n.b)(["orderStatus","isLoading","page"])),{},{page:{set:function(e){this.$store.state.page=e},get:function(){return this.$store.state.page}},hasOrdersStatus:function(){return Boolean(this.orderStatus.data)},getOrdersStatus:function(){return this.orderedOrderStatus()},getLastPage:function(){return this.orderStatus.last_page}}),components:{Loading:c.a},methods:{handleSubmitDelete:function(e,t){var r=this;return u(s.a.mark((function a(){return s.a.wrap((function(a){for(;;)switch(a.prev=a.next){case 0:if(e.preventDefault(),!(!t.id>0)){a.next=3;break}return a.abrupt("return");case 3:return a.next=5,r.delete(t);case 5:case"end":return a.stop()}}),a)})))()},fetch:function(){var e=this;return u(s.a.mark((function t(){return s.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.$store.dispatch("fetch",{model:e.model,page:e.page}).catch((function(t){return e.$toasted.global.ToastedError({message:t.message.message})}));case 2:case"end":return t.stop()}}),t)})))()},delete:function(e){var t=this;return u(s.a.mark((function r(){return s.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,t.$store.dispatch("delete",{_method:"DELETE",model:t.model,data:e}).then(function(){var e=u(s.a.mark((function e(r){return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.$toasted.global.ToastedSuccess({message:"El ".concat(t.model_name," fue eliminado!")}),e.next=3,t.fetch();case 3:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()).catch((function(e){return t.$toasted.global.ToastedError({message:e.message.message})}));case 2:case"end":return r.stop()}}),r)})))()},restore:function(e){var t=this;return u(s.a.mark((function r(){return s.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,t.$store.dispatch("restore",{model:t.model,data:e}).then(function(){var e=u(s.a.mark((function e(r){return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.$toasted.global.ToastedSuccess({message:"El ".concat(t.model_name," fue restaurado!")}),e.next=3,t.fetch();case 3:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()).catch((function(e){return t.$toasted.global.ToastedError({message:e.message.message})}));case 2:case"end":return r.stop()}}),r)})))()},orderedOrderStatus:function(){return Object(i.orderBy)(this.orderStatus.data,"id")},selectedOrderStatus:function(e){var t=this;return u(s.a.mark((function r(){return s.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,t.$store.commit("SET_SELECTED_ORDER_STATUS",{id:e.id,status:e.status,order:e.order,can_delete_order:e.can_delete_order});case 2:case"end":return r.stop()}}),r)})))()},clickCallback:function(e){var t=this;return u(s.a.mark((function r(){return s.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return t.page=e,r.next=3,t.fetch();case 3:case"end":return r.stop()}}),r)})))()}}},m=r("KHd+"),v=Object(m.a)(_,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"table-responsive"},[r("loading",{attrs:{opacity:e.opacity,loader:"spinner",transition:"fade",active:e.isLoading,"can-cancel":!1,"is-full-page":!0,color:"#20a8d8","background-color":"rgba(0,0,0,0.8)"},on:{"update:active":function(t){e.isLoading=t}}}),e._v(" "),r("table",{staticClass:"table table-condensed table-striped table-hover",attrs:{id:"orderStatus-table"}},[e._m(0),e._v(" "),e.hasOrdersStatus?r("tbody",e._l(e.getOrdersStatus,(function(t){return r("tr",{key:t.id,class:{"table-danger":t.deleted_at}},[r("td",{attrs:{scope:"row"}},[e._v(e._s(t.id))]),e._v(" "),r("td",[e._v(e._s(t.status))]),e._v(" "),r("td",[e._v(e._s(t.order))]),e._v(" "),r("td",[e._v(e._s(t.can_delete_order?"Si":"No"))]),e._v(" "),r("td",{staticClass:"text-center"},[r("form",{attrs:{method:"POST","accept-charset":"UTF-8"},on:{submit:function(r){return e.handleSubmitDelete(r,t)}}},[r("div",[r("button",{staticClass:"btn btn-outline-warning btn-sm",attrs:{title:"Editar",disabled:t.deleted_at,type:"button"},on:{click:function(r){return e.selectedOrderStatus(t)}}},[r("i",{staticClass:"icon-note"})]),e._v(" "),t.deleted_at?r("button",{staticClass:"btn btn-success btn-sm",attrs:{title:"Restaurar",type:"button"},on:{click:function(r){return e.restore(t)}}},[r("i",{staticClass:"icon-refresh"})]):r("button",{staticClass:"btn btn-outline-danger btn-sm",attrs:{title:"Eliminar",type:"submit",onclick:"return confirm('¿Estás seguro de que quieres eliminar este elemento?')"}},[r("i",{staticClass:"icon-trash"})])])])])])})),0):e._e()]),e._v(" "),e.hasOrdersStatus?r("section",{staticClass:"col-lg-12 col-sm-12 col-md-12 col-xs-12 center-block text-center d-flex justify-content-center"},[r("paginate",{attrs:{"page-count":e.getLastPage,"page-range":5,"margin-pages":2,"click-handler":e.clickCallback,"prev-text":"&laquo;","next-text":"&raquo;","container-class":"pagination","page-class":"page-item","page-link-class":"page-link","prev-class":"page-item","next-class":"page-item","prev-link-class":"page-link","next-link-class":"page-link","active-class":"active"},model:{value:e.page,callback:function(t){e.page=t},expression:"page"}})],1):e._e()],1)}),[function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("thead",{staticClass:"thead-dark"},[r("tr",[r("th",{attrs:{scope:"col"}},[e._v("ID")]),e._v(" "),r("th",{attrs:{scope:"col"}},[e._v("Estado")]),e._v(" "),r("th",{attrs:{scope:"col"}},[e._v("Orden")]),e._v(" "),r("th",{attrs:{scope:"col"}},[e._v("Borra Orden de Compra")]),e._v(" "),r("th",{staticClass:"text-center",attrs:{scope:"col"}},[r("i",{staticClass:"icon-settings"})])])])}],!1,null,null,null);t.default=v.exports}}]);