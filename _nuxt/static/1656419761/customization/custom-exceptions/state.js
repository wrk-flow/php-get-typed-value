window.__NUXT__=(function(a,b,c,d,e,f,g,h){return {staticAssetsBase:"\u002F_nuxt\u002Fstatic\u002F1656419761",layout:"default",error:c,state:{categories:{en:{"":[{slug:"index",title:"Introduction",to:d,category:a},{slug:"validation",title:"Validation",to:"\u002Fvalidation",category:a}],Customization:[{slug:"custom-data-holder",title:"Custom data holder",category:e,to:"\u002Fcustomization\u002Fcustom-data-holder"},{slug:"custom-exceptions",title:"Custom exceptions",category:e,to:f}],Community:[{slug:"releases",title:"Releases",category:"Community",to:"\u002Freleases"}]}},releases:[{name:"v0.2.1",date:"2022-06-28T12:35:09Z",body:"\u003Cp\u003E⛑ Made \u003Ccode\u003EgetArrayGetter\u003C\u002Fcode\u003E match \u003Ccode\u003EgetArray\u003C\u002Fcode\u003E (returns always array instance) and add \u003Ccode\u003EgetNullableArrayGetter\u003C\u002Fcode\u003E to return null if data is missing or empty.\u003C\u002Fp\u003E\n\u003Ch2 id=\"breaking-change\"\u003EBreaking change\u003C\u002Fh2\u003E\n\u003Cp\u003E🛠 \u003Ccode\u003EgetArrayGetter\u003C\u002Fcode\u003E does not return null any more. Use \u003Ccode\u003EgetNullableArrayGetter\u003C\u002Fcode\u003E instead to get null if data is missing.\u003C\u002Fp\u003E\n"},{name:"v0.2.0",date:"2022-06-28T10:57:44Z",body:"\u003Cp\u003E🚀 Add ability to get validated value (use \u003Ccode\u003Erules: []\u003C\u002Fcode\u003E in methods). \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Fvalidation\"\u003EDocumentation\u003C\u002Fa\u003E.\u003C\u002Fp\u003E\n\u003Cp\u003E⛑ \u003Ccode\u003Eint|string|float|bool|string\u003C\u002Fcode\u003E is now validated and throws \u003Ccode\u003E\\Wrkflow\\GetValue\\Exceptions\\ValidationFailedException\u003C\u002Fcode\u003E.\u003C\u002Fp\u003E\n\u003Ch2 id=\"breaking-change\"\u003EBreaking change\u003C\u002Fh2\u003E\n\u003Cp\u003E🛠 If you are extending exception builder then you need to implement new method\u003C\u002Fp\u003E\n\u003Cpre\u003E\u003Ccode class=\"language-php\"\u003E\u002F**\n * @param class-string&lt;RuleContract&gt; $ruleClassName\n *\u002F\npublic function validationFailed(string $key, string $ruleClassName): Exception;\n\u003C\u002Fcode\u003E\u003C\u002Fpre\u003E\n"},{name:"v0.1.0",date:"2022-06-27T16:47:47Z",body:"\u003Cp\u003E🚀 Initial release\u003C\u002Fp\u003E\n"}],settings:{title:"PHP Get typed value",url:"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com",defaultDir:"docs",defaultBranch:"main",filled:b,github:"wrk-flow\u002Fphp-get-typed-value",twitter:"pionl",category:a},menu:{open:g},i18n:{routeParams:{}}},serverRendered:b,routePath:f,config:{_app:{basePath:d,assetsPath:"\u002F_nuxt\u002F",cdnURL:c},content:{dbHash:"f102e7f0"}},__i18n:{langs:{}},colorMode:{preference:h,value:h,unknown:b,forced:g}}}("",true,null,"\u002F","Customization","\u002Fcustomization\u002Fcustom-exceptions",false,"system"));