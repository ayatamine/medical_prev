import{J as r}from"./JigDd.38a5be27.js";import{I as d}from"./InertiaButton.8ae24674.js";import{_ as i}from"./plugin-vue_export-helper.5a098b48.js";import{e as m,o as c,k as l,x as a,w as e,i as t,y as n}from"./vendor.07ccac9c.js";const _={name:"ShowPermissionsForm",props:{model:Object},components:{InertiaButton:d,JigDd:r},data(){return{}},mounted(){},computed:{flash(){return this.$page.props.flash||{}}},methods:{}},u={class:"gap-4"},p=t("Name:"),f=t("Title:"),h=t("Guard Name:");function g(j,x,o,v,w,B){const s=m("jig-dd");return c(),l("dl",u,[a(s,null,{dt:e(()=>[p]),default:e(()=>[t(" "+n(o.model.name),1)]),_:1}),a(s,null,{dt:e(()=>[f]),default:e(()=>[t(" "+n(o.model.title),1)]),_:1}),a(s,null,{dt:e(()=>[h]),default:e(()=>[t(" "+n(o.model.guard_name),1)]),_:1})])}var I=i(_,[["render",g]]);export{I as default};