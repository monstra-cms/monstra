// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2008 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
// Html tags
// http://en.wikipedia.org/wiki/html
// ----------------------------------------------------------------------------
// Basic set. Feel free to add more tags
// ----------------------------------------------------------------------------
mySettings = {
	onShiftEnter:	{keepDefault:false, replaceWith:'<br>\n'},
	onCtrlEnter:	{keepDefault:false, openWith:'\n<p>', closeWith:'</p>\n'},
	onTab:			{keepDefault:false, openWith:'	 '},
	markupSet: [
		{name:'Heading 1', key:'1', openWith:'<h1(!( class="[![Class]!]")!)>', closeWith:'</h1>', placeHolder:'Your title here...' },
		{name:'Heading 2', key:'2', openWith:'<h2(!( class="[![Class]!]")!)>', closeWith:'</h2>', placeHolder:'Your title here...' },
		{name:'Heading 3', key:'3', openWith:'<h3(!( class="[![Class]!]")!)>', closeWith:'</h3>', placeHolder:'Your title here...' },
		{name:'Heading 4', key:'4', openWith:'<h4(!( class="[![Class]!]")!)>', closeWith:'</h4>', placeHolder:'Your title here...' },
		{name:'Heading 5', key:'5', openWith:'<h5(!( class="[![Class]!]")!)>', closeWith:'</h5>', placeHolder:'Your title here...' },
		{name:'Heading 6', key:'6', openWith:'<h6(!( class="[![Class]!]")!)>', closeWith:'</h6>', placeHolder:'Your title here...' },
		{name:'Paragraph', openWith:'<p(!( class="[![Class]!]")!)>', closeWith:'</p>' },
		{separator:'---------------' },
		{name:'Bold', key:'B', openWith:'(!(<strong>|!|<b>)!)', closeWith:'(!(</strong>|!|</b>)!)' },
		{name:'Italic', key:'I', openWith:'(!(<em>|!|<i>)!)', closeWith:'(!(</em>|!|</i>)!)' },
		{name:'Stroke through', key:'S', openWith:'<del>', closeWith:'</del>' },
		{separator:'---------------' },
		{name:'Ul', openWith:'<ul>\n', closeWith:'</ul>\n' },
		{name:'Ol', openWith:'<ol>\n', closeWith:'</ol>\n' },
		{name:'Li', openWith:'<li>', closeWith:'</li>' },
		{separator:'---------------' },
		{name:'Picture', key:'P', replaceWith:'<img src="[![Source:!:http://]!]" alt="[![Alternative text]!]" />' },
		{name:'Link', key:'L', openWith:'<a href="[![Link:!:http://]!]"(!( title="[![Title]!]")!)>', closeWith:'</a>', placeHolder:'Your text to link...' },
		{name:'Colors', className:'palette', dropMenu: [
				{name:'Yellow',	openWith:'<span style="color:#FCE94F">', closeWith:'</span>', className:"col1-1" },
				{name:'Yellow',	openWith:'<span style="color:#EDD400">', closeWith:'</span>', className:"col1-2" },
				{name:'Yellow', openWith:'<span style="color:#C4A000">', closeWith:'</span>', className:"col1-3" },
				
				{name:'Orange', openWith:'<span style="color:#FCAF3E">', closeWith:'</span>', className:"col2-1" },
				{name:'Orange', openWith:'<span style="color:#F57900">', closeWith:'</span>', className:"col2-2" },
				{name:'Orange', openWith:'<span style="color:#CE5C00">', closeWith:'</span>', className:"col2-3" },
				
				{name:'Brown', 	openWith:'<span style="color:#E9B96E">', closeWith:'</span>', className:"col3-1" },
				{name:'Brown', 	openWith:'<span style="color:#C17D11">', closeWith:'</span>', className:"col3-2" },
				{name:'Brown',	openWith:'<span style="color:#8F5902">', closeWith:'</span>', className:"col3-3" },
				
				{name:'Green', 	openWith:'<span style="color:#8AE234">', closeWith:'</span>', className:"col4-1" },
				{name:'Green', 	openWith:'<span style="color:#73D216">', closeWith:'</span>', className:"col4-2" },
				{name:'Green',	openWith:'<span style="color:#4E9A06">', closeWith:'</span>', className:"col4-3" },
				
				{name:'Blue', 	openWith:'<span style="color:#729FCF">', closeWith:'</span>',	className:"col5-1" },
				{name:'Blue', 	openWith:'<span style="color:#3465A4">', closeWith:'</span>',	className:"col5-2" },
				{name:'Blue',	openWith:'<span style="color:#204A87">', closeWith:'</span>',	className:"col5-3" },
	
				{name:'Purple', openWith:'<span style="color:#AD7FA8">', closeWith:'</span>',	className:"col6-1" },
				{name:'Purple', openWith:'<span style="color:#75507B">', closeWith:'</span>',	className:"col6-2" },
				{name:'Purple',	openWith:'<span style="color:#5C3566">', closeWith:'</span>',	className:"col6-3" },
				
				{name:'Red', 	openWith:'<span style="color:#EF2929">', closeWith:'</span>',	className:"col7-1" },
				{name:'Red', 	openWith:'<span style="color:#CC0000">', closeWith:'</span>',	className:"col7-2" },
				{name:'Red',	openWith:'<span style="color:#A40000">', closeWith:'</span>',	className:"col7-3" },
				
				{name:'Gray', 	openWith:'<span style="color:#FFFFFF">', closeWith:'</span>',	className:"col8-1" },
				{name:'Gray', 	openWith:'<span style="color:#D3D7CF">', closeWith:'</span>',	className:"col8-2" },
				{name:'Gray',	openWith:'<span style="color:#BABDB6">', closeWith:'</span>',	className:"col8-3" },
				
				{name:'Gray', 	openWith:'<span style="color:#888A85">', closeWith:'</span>',	className:"col9-1" },
				{name:'Gray', 	openWith:'<span style="color:#555753">', closeWith:'</span>',	className:"col9-2" },
				{name:'Gray',	openWith:'<span style="color:#000000">', closeWith:'</span>',	className:"col9-3" }
			]
		},
		{separator:'---------------' },
		{name:'Clean', className:'clean', replaceWith:function(markitup) { return markitup.selection.replace(/<(.*?)>/g, "") } },
		{name:'Preview', className:'preview', call:'preview' }
	]
}