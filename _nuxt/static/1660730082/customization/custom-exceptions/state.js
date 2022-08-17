window.__NUXT__=(function(a,b,c,d,e,f,g,h){return {staticAssetsBase:"\u002F_nuxt\u002Fstatic\u002F1660730082",layout:"default",error:c,state:{categories:{en:{"":[{slug:"index",title:"Introduction",to:d,category:a},{slug:"validation",title:"Validation",to:"\u002Fvalidation",category:a},{slug:"transformers",title:"Transformers",to:"\u002Ftransformers",category:a}],Customization:[{slug:"custom-data-holder",title:"Custom data holder",category:e,to:"\u002Fcustomization\u002Fcustom-data-holder"},{slug:"custom-exceptions",title:"Custom exceptions",category:e,to:f}],Community:[{slug:"releases",title:"Releases",category:"Community",to:"\u002Freleases"}]}},releases:[{name:"v0.6.1",date:"2022-08-17T09:53:30Z",body:"\u003Cp\u003E🚀 Allow passing transformer object instead of closure using\u003Cem\u003EGetValueTransformerContract\u003C\u002Fem\u003E. \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Ftransformers\u002F#gettertransformer\"\u003EDocs\u003C\u002Fa\u003E\n💪 Get value with object transforming to desired type (using \u003Cem\u003EGetValueTransformerContract\u003C\u002Fem\u003E) with correct type hint. \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002F#getobject\"\u003EDocs\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.6.0...v0.6.1\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.6.0...v0.6.1\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.6.0",date:"2022-08-15T13:14:32Z",body:"\u003Cp\u003E🚀 Improved XML support\u003C\u002Fp\u003E\n\u003Cul\u003E\n\u003Cli\u003EGetterTransformer - Wraps value into GetValue instance (xml or array)\u003C\u002Fli\u003E\n\u003Cli\u003EgetRequiredXMLGetter, getXMLAttributesGetter, getNullableXMLGetter, getXMLGetter, getRequiredXML, getNullableXML methods\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Ch2 id=\"🛠-breaking-change-minor\"\u003E🛠 Breaking change (minor)\u003C\u002Fh2\u003E\n\u003Cul\u003E\n\u003Cli\u003EArrayGetterTransformer renamed to GetterTransformer. This class was not documented.\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.5.1...v0.6.0\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.5.1...v0.6.0\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.5.1",date:"2022-07-05T15:39:54Z",body:"\u003Cp\u003E⛑ Allow usage of \u003Ccode\u003EArray*Transformers\u003C\u002Fcode\u003E in all \u003Ccode\u003Eget*\u003C\u002Fcode\u003E methods\n🚀 Ignore null values while re-building an array (ArrayItemTransformer, ArrayItemGetterTransformer)\u003C\u002Fp\u003E\n\u003Ch2 id=\"🛠-breaking-change\"\u003E🛠 Breaking change\u003C\u002Fh2\u003E\n\u003Cul\u003E\n\u003Cli\u003ETransformerArrayContract removed\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.5.0...v0.5.1\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.5.0...v0.5.1\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.5.0",date:"2022-06-30T15:02:04Z",body:"\u003Cp\u003E🚀 Add safe dot annotation for accessing values from child arrays. \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002F#dot-notation\"\u003EDocumentation\u003C\u002Fa\u003E\n🛠 Key contains parent key for exceptions that were thrown from GetValue instances that were created as child instances.\u003C\u002Fp\u003E\n\u003Ch2 id=\"breaking-changes\"\u003EBreaking changes\u003C\u002Fh2\u003E\n\u003Cul\u003E\n\u003Cli\u003EAbstractGetValueException has new required argument in constructor - \u003Ccode\u003E$key\u003C\u002Fcode\u003E\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Cstrong\u003EIf you are extending \u003Ccode\u003EGetValue\u003C\u002Fcode\u003E\u003C\u002Fstrong\u003E: $key argument accepts \u003Ccode\u003Estring|array\u003C\u002Fcode\u003E instead of \u003Ccode\u003Estring\u003C\u002Fcode\u003E.\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.4...v0.5.0\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.4...v0.5.0\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.4.4",date:"2022-06-29T15:54:45Z",body:"\u003Cp\u003E⛑ Fix ArrayGetterTransformer closure type hints for PHPStan\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.3...v0.4.4\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.3...v0.4.4\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.4.3",date:"2022-06-29T15:21:03Z",body:"\u003Cp\u003E🚀 Add support for enums: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002F#enum\"\u003Eget methods\u003C\u002Fa\u003E,  \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Fvalidation\u002F#enumrule\"\u003EEnumRule\u003C\u002Fa\u003E.\u003C\u002Fp\u003E\n"},{name:"v0.4.2",date:"2022-06-29T14:10:25Z",body:"\u003Cp\u003E⛽️ Add ability to validate HEX colors using \u003Ccode\u003EHexColorRule\u003C\u002Fcode\u003E. \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Fvalidation\u002F#hexcolorrule\"\u003EDocumentation\u003C\u002Fa\u003E.\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.1...v0.4.2\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.1...v0.4.2\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.4.1",date:"2022-06-29T13:36:25Z",body:"\u003Cp\u003E🚀 Add ArrayGetterTransformer to get array object wrapped in GetValue \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Ftransformers#arrayitemgettertransformer-1\"\u003EDocumentation\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.0...v0.4.1\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.0...v0.4.1\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.4.0",date:"2022-06-29T09:46:32Z",body:"\u003Cp\u003E🚀 Add array item transformer that has wrapped array value in GetValue instance. \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Ftransformers\u002F#arrayitemgettertransformer\"\u003EDocumentation\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n\u003Cpre\u003E\u003Ccode class=\"language-php\"\u003E$transformer = new ArrayItemGetterTransformer( function (\\Wrkflow\\GetValue\\GetValue $value, string $key): string {\n    return [\n        self::KeyValue =&gt; $value-&gt;getRequiredString(self::KeyValue),\n    ];\n});\n\n$values = $getValue-&gt;getArray(&#39;key&#39;, [$transformer]);\n\u003C\u002Fcode\u003E\u003C\u002Fpre\u003E\n\u003Cp\u003E🛠 \u003Ccode\u003E$getValue-&gt;makeInstance\u003C\u002Fcode\u003E will allow you to create new instance of GetValue with same strategy\u002Fbuilder\u002Factions.\u003C\u002Fp\u003E\n\u003Ch2 id=\"breaking-changes\"\u003EBreaking changes\u003C\u002Fh2\u003E\n\u003Ch3 id=\"critical\"\u003ECritical\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003ERenamed \u003Ccode\u003EClosureArrayItemsTransformer\u003C\u002Fcode\u003E to \u003Ccode\u003EArrayItemTransformer\u003C\u002Fcode\u003E\u003C\u002Fli\u003E\n\u003Cli\u003ERenamed \u003Ccode\u003EClosureArrayTransformer\u003C\u002Fcode\u003E to \u003Ccode\u003EArrayTransformer\u003C\u002Fcode\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Ch3 id=\"minor\"\u003EMinor\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003ETransformers \u003Ccode\u003Etransform\u003C\u002Fcode\u003E method has new parameter \u003Ccode\u003EGetValue $getValue\u003C\u002Fcode\u003E - update your transformers or transform calls.\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cpre\u003E\u003Ccode class=\"language-php\"\u003Epublic function transform(mixed $value, string $key, GetValue $getValue): mixed\n\u003C\u002Fcode\u003E\u003C\u002Fpre\u003E\n"},{name:"v0.3.1",date:"2022-06-28T16:32:00Z",body:"\u003Cp\u003E🚀 Array closures transformers \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Ftransformers\u002F#closurearraytransformer\"\u003EDocumentation\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.3.0",date:"2022-06-28T15:22:18Z",body:"\u003Cp\u003E🚀 Add ability to transform value before (most transforms) and after validation (mostly your custom transformations).\u003C\u002Fp\u003E\n\u003Ch2 id=\"breaking-change\"\u003EBreaking change\u003C\u002Fh2\u003E\n\u003Cp\u003EBy my opinion I&#39;ve implemented default strategy based on my usage on all projects:\u003C\u002Fp\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Cstrong\u003Estring\u003C\u002Fstrong\u003E -&gt; string is always trimmed and if it is empty then it will be transformed to null\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Cstrong\u003Ebool\u003C\u002Fstrong\u003E -&gt; Converts most used representations of boolean in string or number (&#39;yes&#39;,&#39;no&#39;,1,0,&#39;1&#39;,&#39;0&#39;,&#39;true&#39;,&#39;false&#39;) and converts it to bool.\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cp\u003EAlso, if you are not using named arguments you need to update:\u003C\u002Fp\u003E\n\u003Ch3 id=\"getvalue__construct\"\u003E\u003Ccode\u003EGetValue::__construct\u003C\u002Fcode\u003E\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Cstrong\u003Enew argument\u003C\u002Fstrong\u003E $transformerStrategy. This will be mostly used for tweaking.\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Ccode\u003E$getValidatedValueAction\u003C\u002Fcode\u003E was moved as last argument. Probably will not be used.\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Ccode\u003E$exceptionBuilder\u003C\u002Fcode\u003E - was moved before \u003Ccode\u003E$getValidatedValueAction\u003C\u002Fcode\u003E \u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cpre\u003E\u003Ccode class=\"language-php\"\u003E public function __construct(\n        public readonly AbstractData $data,\n        public readonly TransformerStrategy $transformerStrategy = new DefaultTransformerStrategy(),\n        public readonly ExceptionBuilderContract $exceptionBuilder = new ExceptionBuilder(),\n        GetValidatedValueAction $getValidatedValueAction = null,\n    );\n\u003C\u002Fcode\u003E\u003C\u002Fpre\u003E\n"},{name:"v0.2.1",date:"2022-06-28T12:35:09Z",body:"\u003Cp\u003E⛑ Made \u003Ccode\u003EgetArrayGetter\u003C\u002Fcode\u003E match \u003Ccode\u003EgetArray\u003C\u002Fcode\u003E (returns always array instance) and add \u003Ccode\u003EgetNullableArrayGetter\u003C\u002Fcode\u003E to return null if data is missing or empty.\u003C\u002Fp\u003E\n\u003Ch2 id=\"breaking-change\"\u003EBreaking change\u003C\u002Fh2\u003E\n\u003Cp\u003E🛠 \u003Ccode\u003EgetArrayGetter\u003C\u002Fcode\u003E does not return null any more. Use \u003Ccode\u003EgetNullableArrayGetter\u003C\u002Fcode\u003E instead to get null if data is missing.\u003C\u002Fp\u003E\n"},{name:"v0.2.0",date:"2022-06-28T10:57:44Z",body:"\u003Cp\u003E🚀 Add ability to get validated value (use \u003Ccode\u003Erules: []\u003C\u002Fcode\u003E in methods). \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Fvalidation\"\u003EDocumentation\u003C\u002Fa\u003E.\u003C\u002Fp\u003E\n\u003Cp\u003E⛑ \u003Ccode\u003Eint|string|float|bool|string\u003C\u002Fcode\u003E is now validated and throws \u003Ccode\u003E\\Wrkflow\\GetValue\\Exceptions\\ValidationFailedException\u003C\u002Fcode\u003E.\u003C\u002Fp\u003E\n\u003Ch2 id=\"breaking-change\"\u003EBreaking change\u003C\u002Fh2\u003E\n\u003Cp\u003E🛠 If you are extending exception builder then you need to implement new method\u003C\u002Fp\u003E\n\u003Cpre\u003E\u003Ccode class=\"language-php\"\u003E\u002F**\n * @param class-string&lt;RuleContract&gt; $ruleClassName\n *\u002F\npublic function validationFailed(string $key, string $ruleClassName): Exception;\n\u003C\u002Fcode\u003E\u003C\u002Fpre\u003E\n"},{name:"v0.1.0",date:"2022-06-27T16:47:47Z",body:"\u003Cp\u003E🚀 Initial release\u003C\u002Fp\u003E\n"}],settings:{title:"PHP Get typed value",url:"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com",defaultDir:"docs",defaultBranch:"main",filled:b,github:"wrk-flow\u002Fphp-get-typed-value",twitter:"pionl",category:a},menu:{open:g},i18n:{routeParams:{}}},serverRendered:b,routePath:f,config:{_app:{basePath:d,assetsPath:"\u002F_nuxt\u002F",cdnURL:c},content:{dbHash:"210e3f35"}},__i18n:{langs:{}},colorMode:{preference:h,value:h,unknown:b,forced:g}}}("",true,null,"\u002F","Customization","\u002Fcustomization\u002Fcustom-exceptions",false,"system"));