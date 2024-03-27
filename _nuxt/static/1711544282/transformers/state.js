window.__NUXT__=(function(a,b,c,d,e,f,g,h){return {staticAssetsBase:"\u002F_nuxt\u002Fstatic\u002F1711544282",layout:"default",error:c,state:{categories:{en:{"":[{slug:"index",title:"Introduction",to:d,category:a},{slug:"validation",title:"Validation",to:"\u002Fvalidation",category:a},{slug:"transformers",title:"Transformers",to:e,category:a},{slug:"laravel",title:"Laravel",to:"\u002Flaravel",category:a}],Customization:[{slug:"custom-data-holder",title:"Custom data holder",category:f,to:"\u002Fcustomization\u002Fcustom-data-holder"},{slug:"custom-exceptions",title:"Custom exceptions",category:f,to:"\u002Fcustomization\u002Fcustom-exceptions"}],Community:[{slug:"releases",title:"Releases",category:"Community",to:"\u002Freleases"}]}},releases:[{name:"v0.9.0",date:"2024-03-27T12:57:08Z",body:"\u003Cp\u003E👮‍♀️ Pass full key in ArrayItem\u002FArrayItemGetterTransformer\u003C\u002Fp\u003E\n\u003Cp\u003EBREAKING CHANGE: if you used $key (low chance) then now you will get full key including the looped item key\u003C\u002Fp\u003E\n"},{name:"v0.8.3",date:"2023-10-12T11:26:54Z",body:"\u003Cp\u003E🎉 \u003Cstrong\u003ELaravel:\u003C\u002Fstrong\u003E GetValueFactory-&gt;command() wraps command arguments \u002F options for type safe access. \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Flaravel#getvaluefactory\"\u003Edocs\u003C\u002Fa\u003E\n🎉 \u003Cstrong\u003ELaravel:\u003C\u002Fstrong\u003E You can extend \u003Ccode\u003EGetValueFactoryCommand\u003C\u002Fcode\u003E that wraps command arguments \u002F options in \u003Ccode\u003EGetValue  $inputData\u003C\u002Fcode\u003E property you can access within your command. \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Flaravel#command-input\"\u003Edocs\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.8.2",date:"2023-07-25T12:32:36Z",body:"\u003Cp\u003E⛑️ Add support for accessing arrays by numeric index in XML\n🚀 Add support for accessing XML childrens using namespace prefix\u003C\u002Fp\u003E\n"},{name:"v0.8.1",date:"2022-10-11T10:56:01Z",body:"\u003Cp\u003E🚀 \u003Cstrong\u003EgetFloat\u003C\u002Fstrong\u003E: Add support for float values using comma\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.8.0...v0.8.1\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.8.0...v0.8.1\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.8.0",date:"2022-09-23T10:29:04Z",body:"\u003Cp\u003E⛑ In default strategy ensure that \u003Ccode\u003Eempty string\u003C\u002Fcode\u003E values are converted to null in all value types.\n🚀 Improve validation exception text with value description: \u003Ccode\u003E(null)\u003C\u002Fcode\u003E, \u003Ccode\u003E(array with count X)\u003C\u002Fcode\u003E, \u003Ccode\u003E(empty string)\u003C\u002Fcode\u003E, string value with maximum of 30 characters.\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EBreaking changes (small chance):\u003C\u002Fstrong\u003E\u003C\u002Fp\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ccode\u003ETransformerStrategy\u003C\u002Fcode\u003E renamed to \u003Ccode\u003ETransformerStrategyContract\u003C\u002Fcode\u003E\u003C\u002Fli\u003E\n\u003Cli\u003EEmpty string values are automatically converted to null.\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.7.1...v0.8.0\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.7.1...v0.8.0\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.7.1",date:"2022-09-22T11:40:46Z",body:"\u003Cp\u003E🚀 Add ability to automatically build GetValue instance within FormRequest instance. \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Flaravel\u002F\"\u003EDocs\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.7.0...v0.7.1\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.7.0...v0.7.1\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.7.0",date:"2022-09-12T14:12:34Z",body:"\u003Cp\u003E🚀 Add value to ValidationException message. \u003C\u002Fp\u003E\n\u003Ch1 id=\"breaking-change\"\u003EBreaking change\u003C\u002Fh1\u003E\n\u003Cp\u003E\u003Ccode\u003EExceptionBuilderContract\u003C\u002Fcode\u003E has new function signature.\u003C\u002Fp\u003E\n\u003Cpre\u003E\u003Ccode class=\"language-php\"\u003Epublic function validationFailed(string $key, string $ruleClassName): Exception\n\u003C\u002Fcode\u003E\u003C\u002Fpre\u003E\n\u003Cp\u003Eto \u003C\u002Fp\u003E\n\u003Cpre\u003E\u003Ccode class=\"language-php\"\u003Epublic function validationFailed(string $key, string $ruleClassName, ?string $value): Exception\n\u003C\u002Fcode\u003E\u003C\u002Fpre\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.6.4...v0.7.0\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.6.4...v0.7.0\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.6.4",date:"2022-08-23T13:21:19Z",body:"\u003Cp\u003E⛑ Fix enum rule with int enum but value in string (xml)\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.6.3...v0.6.4\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.6.3...v0.6.4\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.6.3",date:"2022-08-19T10:51:24Z",body:"\u003Cp\u003E🚀 Add GetValueFactory for dependency injection usages\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.6.2...v0.6.3\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.6.2...v0.6.3\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.6.2",date:"2022-08-18T17:43:51Z",body:"\u003Cp\u003E🚀 Add \u003Ccode\u003EgetRequiredObject\u003C\u002Fcode\u003E variant\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.6.1...v0.6.2\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.6.1...v0.6.2\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.6.1",date:"2022-08-17T09:53:30Z",body:"\u003Cp\u003E🚀 Allow passing transformer object instead of closure using\u003Cem\u003EGetValueTransformerContract\u003C\u002Fem\u003E. \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Ftransformers\u002F#gettertransformer\"\u003EDocs\u003C\u002Fa\u003E\n💪 Get value with object transforming to desired type (using \u003Cem\u003EGetValueTransformerContract\u003C\u002Fem\u003E) with correct type hint. \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002F#getobject\"\u003EDocs\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.6.0...v0.6.1\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.6.0...v0.6.1\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.6.0",date:"2022-08-15T13:14:32Z",body:"\u003Cp\u003E🚀 Improved XML support\u003C\u002Fp\u003E\n\u003Cul\u003E\n\u003Cli\u003EGetterTransformer - Wraps value into GetValue instance (xml or array)\u003C\u002Fli\u003E\n\u003Cli\u003EgetRequiredXMLGetter, getXMLAttributesGetter, getNullableXMLGetter, getXMLGetter, getRequiredXML, getNullableXML methods\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Ch2 id=\"🛠-breaking-change-minor\"\u003E🛠 Breaking change (minor)\u003C\u002Fh2\u003E\n\u003Cul\u003E\n\u003Cli\u003EArrayGetterTransformer renamed to GetterTransformer. This class was not documented.\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.5.1...v0.6.0\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.5.1...v0.6.0\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.5.1",date:"2022-07-05T15:39:54Z",body:"\u003Cp\u003E⛑ Allow usage of \u003Ccode\u003EArray*Transformers\u003C\u002Fcode\u003E in all \u003Ccode\u003Eget*\u003C\u002Fcode\u003E methods\n🚀 Ignore null values while re-building an array (ArrayItemTransformer, ArrayItemGetterTransformer)\u003C\u002Fp\u003E\n\u003Ch2 id=\"🛠-breaking-change\"\u003E🛠 Breaking change\u003C\u002Fh2\u003E\n\u003Cul\u003E\n\u003Cli\u003ETransformerArrayContract removed\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.5.0...v0.5.1\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.5.0...v0.5.1\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.5.0",date:"2022-06-30T15:02:04Z",body:"\u003Cp\u003E🚀 Add safe dot annotation for accessing values from child arrays. \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002F#dot-notation\"\u003EDocumentation\u003C\u002Fa\u003E\n🛠 Key contains parent key for exceptions that were thrown from GetValue instances that were created as child instances.\u003C\u002Fp\u003E\n\u003Ch2 id=\"breaking-changes\"\u003EBreaking changes\u003C\u002Fh2\u003E\n\u003Cul\u003E\n\u003Cli\u003EAbstractGetValueException has new required argument in constructor - \u003Ccode\u003E$key\u003C\u002Fcode\u003E\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Cstrong\u003EIf you are extending \u003Ccode\u003EGetValue\u003C\u002Fcode\u003E\u003C\u002Fstrong\u003E: $key argument accepts \u003Ccode\u003Estring|array\u003C\u002Fcode\u003E instead of \u003Ccode\u003Estring\u003C\u002Fcode\u003E.\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.4...v0.5.0\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.4...v0.5.0\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.4.4",date:"2022-06-29T15:54:45Z",body:"\u003Cp\u003E⛑ Fix ArrayGetterTransformer closure type hints for PHPStan\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.3...v0.4.4\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.3...v0.4.4\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.4.3",date:"2022-06-29T15:21:03Z",body:"\u003Cp\u003E🚀 Add support for enums: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002F#enum\"\u003Eget methods\u003C\u002Fa\u003E,  \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Fvalidation\u002F#enumrule\"\u003EEnumRule\u003C\u002Fa\u003E.\u003C\u002Fp\u003E\n"},{name:"v0.4.2",date:"2022-06-29T14:10:25Z",body:"\u003Cp\u003E⛽️ Add ability to validate HEX colors using \u003Ccode\u003EHexColorRule\u003C\u002Fcode\u003E. \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Fvalidation\u002F#hexcolorrule\"\u003EDocumentation\u003C\u002Fa\u003E.\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.1...v0.4.2\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.1...v0.4.2\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.4.1",date:"2022-06-29T13:36:25Z",body:"\u003Cp\u003E🚀 Add ArrayGetterTransformer to get array object wrapped in GetValue \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Ftransformers#arrayitemgettertransformer-1\"\u003EDocumentation\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n\u003Cp\u003E\u003Cstrong\u003EFull Changelog\u003C\u002Fstrong\u003E: \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.0...v0.4.1\"\u003Ehttps:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Fphp-get-typed-value\u002Fcompare\u002Fv0.4.0...v0.4.1\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.4.0",date:"2022-06-29T09:46:32Z",body:"\u003Cp\u003E🚀 Add array item transformer that has wrapped array value in GetValue instance. \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Ftransformers\u002F#arrayitemgettertransformer\"\u003EDocumentation\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n\u003Cpre\u003E\u003Ccode class=\"language-php\"\u003E$transformer = new ArrayItemGetterTransformer( function (\\Wrkflow\\GetValue\\GetValue $value, string $key): string {\n    return [\n        self::KeyValue =&gt; $value-&gt;getRequiredString(self::KeyValue),\n    ];\n});\n\n$values = $getValue-&gt;getArray(&#39;key&#39;, [$transformer]);\n\u003C\u002Fcode\u003E\u003C\u002Fpre\u003E\n\u003Cp\u003E🛠 \u003Ccode\u003E$getValue-&gt;makeInstance\u003C\u002Fcode\u003E will allow you to create new instance of GetValue with same strategy\u002Fbuilder\u002Factions.\u003C\u002Fp\u003E\n\u003Ch2 id=\"breaking-changes\"\u003EBreaking changes\u003C\u002Fh2\u003E\n\u003Ch3 id=\"critical\"\u003ECritical\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003ERenamed \u003Ccode\u003EClosureArrayItemsTransformer\u003C\u002Fcode\u003E to \u003Ccode\u003EArrayItemTransformer\u003C\u002Fcode\u003E\u003C\u002Fli\u003E\n\u003Cli\u003ERenamed \u003Ccode\u003EClosureArrayTransformer\u003C\u002Fcode\u003E to \u003Ccode\u003EArrayTransformer\u003C\u002Fcode\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Ch3 id=\"minor\"\u003EMinor\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003ETransformers \u003Ccode\u003Etransform\u003C\u002Fcode\u003E method has new parameter \u003Ccode\u003EGetValue $getValue\u003C\u002Fcode\u003E - update your transformers or transform calls.\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cpre\u003E\u003Ccode class=\"language-php\"\u003Epublic function transform(mixed $value, string $key, GetValue $getValue): mixed\n\u003C\u002Fcode\u003E\u003C\u002Fpre\u003E\n"},{name:"v0.3.1",date:"2022-06-28T16:32:00Z",body:"\u003Cp\u003E🚀 Array closures transformers \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Ftransformers\u002F#closurearraytransformer\"\u003EDocumentation\u003C\u002Fa\u003E\u003C\u002Fp\u003E\n"},{name:"v0.3.0",date:"2022-06-28T15:22:18Z",body:"\u003Cp\u003E🚀 Add ability to transform value before (most transforms) and after validation (mostly your custom transformations).\u003C\u002Fp\u003E\n\u003Ch2 id=\"breaking-change\"\u003EBreaking change\u003C\u002Fh2\u003E\n\u003Cp\u003EBy my opinion I&#39;ve implemented default strategy based on my usage on all projects:\u003C\u002Fp\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Cstrong\u003Estring\u003C\u002Fstrong\u003E -&gt; string is always trimmed and if it is empty then it will be transformed to null\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Cstrong\u003Ebool\u003C\u002Fstrong\u003E -&gt; Converts most used representations of boolean in string or number (&#39;yes&#39;,&#39;no&#39;,1,0,&#39;1&#39;,&#39;0&#39;,&#39;true&#39;,&#39;false&#39;) and converts it to bool.\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cp\u003EAlso, if you are not using named arguments you need to update:\u003C\u002Fp\u003E\n\u003Ch3 id=\"getvalue__construct\"\u003E\u003Ccode\u003EGetValue::__construct\u003C\u002Fcode\u003E\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Cstrong\u003Enew argument\u003C\u002Fstrong\u003E $transformerStrategy. This will be mostly used for tweaking.\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Ccode\u003E$getValidatedValueAction\u003C\u002Fcode\u003E was moved as last argument. Probably will not be used.\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Ccode\u003E$exceptionBuilder\u003C\u002Fcode\u003E - was moved before \u003Ccode\u003E$getValidatedValueAction\u003C\u002Fcode\u003E \u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cpre\u003E\u003Ccode class=\"language-php\"\u003E public function __construct(\n        public readonly AbstractData $data,\n        public readonly TransformerStrategy $transformerStrategy = new DefaultTransformerStrategy(),\n        public readonly ExceptionBuilderContract $exceptionBuilder = new ExceptionBuilder(),\n        GetValidatedValueAction $getValidatedValueAction = null,\n    );\n\u003C\u002Fcode\u003E\u003C\u002Fpre\u003E\n"},{name:"v0.2.1",date:"2022-06-28T12:35:09Z",body:"\u003Cp\u003E⛑ Made \u003Ccode\u003EgetArrayGetter\u003C\u002Fcode\u003E match \u003Ccode\u003EgetArray\u003C\u002Fcode\u003E (returns always array instance) and add \u003Ccode\u003EgetNullableArrayGetter\u003C\u002Fcode\u003E to return null if data is missing or empty.\u003C\u002Fp\u003E\n\u003Ch2 id=\"breaking-change\"\u003EBreaking change\u003C\u002Fh2\u003E\n\u003Cp\u003E🛠 \u003Ccode\u003EgetArrayGetter\u003C\u002Fcode\u003E does not return null any more. Use \u003Ccode\u003EgetNullableArrayGetter\u003C\u002Fcode\u003E instead to get null if data is missing.\u003C\u002Fp\u003E\n"},{name:"v0.2.0",date:"2022-06-28T10:57:44Z",body:"\u003Cp\u003E🚀 Add ability to get validated value (use \u003Ccode\u003Erules: []\u003C\u002Fcode\u003E in methods). \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com\u002Fvalidation\"\u003EDocumentation\u003C\u002Fa\u003E.\u003C\u002Fp\u003E\n\u003Cp\u003E⛑ \u003Ccode\u003Eint|string|float|bool|string\u003C\u002Fcode\u003E is now validated and throws \u003Ccode\u003E\\Wrkflow\\GetValue\\Exceptions\\ValidationFailedException\u003C\u002Fcode\u003E.\u003C\u002Fp\u003E\n\u003Ch2 id=\"breaking-change\"\u003EBreaking change\u003C\u002Fh2\u003E\n\u003Cp\u003E🛠 If you are extending exception builder then you need to implement new method\u003C\u002Fp\u003E\n\u003Cpre\u003E\u003Ccode class=\"language-php\"\u003E\u002F**\n * @param class-string&lt;RuleContract&gt; $ruleClassName\n *\u002F\npublic function validationFailed(string $key, string $ruleClassName): Exception;\n\u003C\u002Fcode\u003E\u003C\u002Fpre\u003E\n"},{name:"v0.1.0",date:"2022-06-27T16:47:47Z",body:"\u003Cp\u003E🚀 Initial release\u003C\u002Fp\u003E\n"}],settings:{title:"PHP Get typed value",url:"https:\u002F\u002Fphp-get-typed-value.wrk-flow.com",defaultDir:"docs",defaultBranch:"main",filled:b,github:"wrk-flow\u002Fphp-get-typed-value",twitter:"pionl",category:a},menu:{open:g},i18n:{routeParams:{}}},serverRendered:b,routePath:e,config:{_app:{basePath:d,assetsPath:"\u002F_nuxt\u002F",cdnURL:c},content:{dbHash:"0bfbe223"}},__i18n:{langs:{}},colorMode:{preference:h,value:h,unknown:b,forced:g}}}("",true,null,"\u002F","\u002Ftransformers","Customization",false,"system"));