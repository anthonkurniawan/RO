const ST_REJECTED=1, ST_OPEN=2, ST_ONPROGRESS=3, ST_COMPLETE=4;
window.app = (function($) {
  $.ajaxSettings.timeout = 0;
  var fn = {
		root: '/ro/',
    rewrite_on: true,
    pagesize: 8,
		notif: null,
    loaderActive: false,
    url_his: [],
		ldap_users: [],
    user:{},
		msgs:[],
		form_edited:false,
		verbose:true,
		notify_setting:{
			type: 'default',
			element: "body",
			allow_dismiss: !0,
			placement: {from:'top',align:'right'},
			offset: {x: 15,y: 15 },
			spacing: 10,
			z_index: 1080,
			delay: 1500,
			timer: 3000,
			url_target: "_blank",
			mouse_over: !1,
			animate: {
				enter: 'animate__animated animate__fadeInDown',
				exit: 'animate__animated animate__fadeOutUp'
			},
			template: '<div data-notify="container" class="alert alert-dismissible alert-{0} alert-notify" role="alert"><span class="alert-icon" data-notify="icon"></span> <div class="alert-text"</div> <span class="alert-title" data-notify="title">{1}</span> <span data-notify="message">{2}</span></div><button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
    },
		setUser: function(){
      this.user.uid = $('#uid').val();
    },
		homeUrl: function(){
			var base = this.rewrite_on ? this.root : this.root + 'index.php';
			return yii.getBaseCurrentUrl() + base;
    },
    getUrl: function () {
      var arr = window.location.pathname.split('/');
      return {
        script: arr.pop(),
        path: arr.join('/')
      };
    },
    current_url: function(){
      return decodeURIComponent(app.url_his[app.url_his.length-1]);
    },
    setUrlHis: function(url){
      var idx = this.url_his.indexOf(url);
      if(this.url_his.length > 1 && idx >= 0){
        this.url_his.splice(idx+1, this.url_his.length);
      }
      else{
        if(!this.url_his.includes(url)) this.url_his.push(url);
      }
			if(app.verbose) console.log(`> setUrlHis: ${url}`, app.url_his);
    },
    pjax_goback: function(idx){
			if(app.url_his.length==1)
				return this.pjax_goto(app.homeUrl());
      var count = app.url_his.length -1;
      idx = idx ? idx : 1;
      if(idx > count) idx = count;
      var url = app.url_his[count-idx];
			if(app.verbose) console.log(`> pjax_goback- idx:${idx} url:${url}`);
      this.pjax_goto(url);
    },
    pjax_goto: function(url, push=false){
			if(app.verbose) console.log('> pjax_goto', url);
			var fn = function(){
				if(!url) url = app.homeUrl();
				if($.pjax) $.pjax({url:url, container: '#pjax-con', push:push, timeout:0});
				else window.location = url;
			}
			
			if(app.form_edited){
				app.form_edited = false;
				$('.edited').fadeOut();
			}

			if($('.alert-notify').length){
				setTimeout(fn, 2000);
			} else fn();
    },
    setMsg: function(msg, type='default', title=null, icon='glyphicon glyphicon-bell'){
			this.notify_setting.type = type;
      this.notif = $.notify({icon:icon, title:title, message:msg, url:""}, this.notify_setting);
    },
		storeMsg: function(msg, type='default', title=null, icon='glyphicon glyphicon-bell'){
			if($.pjax)
				this.msgs.push({'msg':msg, 'type':type, 'title':title, 'icon':icon});
			else
				this.setMsg(msg, type, title, icon);
		},
		getMsgs: function(){
			if(!app.msgs.length) return;
			for(var i=0; i < this.msgs.length; i++){
				var m = this.msgs[i];
				this.setMsg(m.msg, m.type, m.title, m.icon);
				this.msgs.splice(i,1);
				i--;
			}
		},
    hapus: function(url){
      event.preventDefault();
      if(!confirm("Are you sure to delete this data?")) return;
      $.post(url, function(data) {
        if(data.success){
					app.storeMsg(data.msg, 'info');
          if(app.url_his > 1 && $.pjax.state.url.match(/view/)) app.pjax_goback(2);
          else app.pjax_goback();
        }
      });
      return false;
    },
		inactive: function(url){
      event.preventDefault();
			if(!confirm("Are you sure to inactive this user?")) return;
      $.post(url, function(data) {
        if(data.success){
					app.storeMsg(data.msg, 'info');
          if(app.url_his > 1 && $.pjax.state.url.match(/view/)) app.pjax_goback(2);
          else app.pjax_goback();
        }
      });
      return false;
		},
    setLoader: function(){
      if(this.loaderActive) return;
			$('body').addClass('wait')
      if(app.getUrl().script){  // home not include
        $('.loader').show();
      }else{
        $('#no-data').fadeOut();
      }
			$('.footer').addClass('line-loader');
      this.loaderActive = true;
			if(app.verbose) console.log('> setLoader active:', app.loaderActive);
    },
    removeLoader: function(){
      $('.loader').hide();
			$('.footer').removeClass('line-loader');
      $('.input-line-loader').removeClass('line-loader');
      $('body').removeClass('wait')
			this.loaderActive = false;
			if(app.verbose) console.log('> removeLoader active:', app.loaderActive);
    },
    openOrder: function(e){
      e.preventDefault();
      if(e.target.tagName=='SPAN')
				return;

      var self = $(this);
      var url = self.attr('data-url'); 
			if(app.verbose) console.log('OPEN ORDER..', url);
      $.pjax({url:url, container:'#pjax-con', push:false, timeout:0});
    },
		registerPageContainer: function(container){
			if(container.hasClass('full')){
				container.removeClass('full').addClass('animate__animated animate__fadeIn');
				setTimeout(function(){ container.removeClass('animate__animated animate__fadeIn'); }, 1500);
			}
		},
		registerPageOrder: function(orderId){
			if(app.verbose) console.log('> registerPageOrder', orderId);
			let container = $('.container');
			let button_pdf = $('#order_btn.printPdf');
			this.registerPageContainer(container);
			this.registerSearchBtn();
		},
    printOrder: function(el, id){
      window.onbeforeunload = null;
      var par = app.rewrite_on ? '/'+id : '&id='+id;
			var url = el.href + par;
			if(app.verbose) console.log('PrintOrder', url);
			$.ajax({
				url: url,
				success: function(res, status, xhr) {
					if(xhr.getResponseHeader('content-type')=='application/json; charset=UTF-8')
						app.setMsg(res.error, 'danger');
					else
						window.location = url;
				}
			});
    },
		setDept: function(dept, el) {
			if(!dept_list.length) return;
			for (var i = 0; i < dept_list.length; i++){ 
				var regex = new RegExp(dept_list[i]);
				if(app.verbose) console.log(i, dept_list[i], regex, dept.match(regex));
				if(dept.match(regex)){ 
					el.val(i);
					return;
				}
			}		
		},
    getBreadcrumb: function(){
			var host = app.homeUrl();
      if(app.rewrite_on){
        var url = app.current_url().replace(app.homeUrl(), '');
				alert(app.current_url());
				
        var arr = url.split('/');
      }
      else{
        var url = new URL(app.current_url());
				var str = url.searchParams.get('r');
				if(!str) return;
				var arr = str.split('/');
				host += '?r=';
      }
      
			if($('.breadcrumb li:last-child').text()==arr[arr.length-1])
				return;
			if(app.verbose) console.log('> getBreadcrumb', url, arr);
			
			var li = `<li><a href="${app.homeUrl()}">Home</a></li>\n`;
      for(var i=0; i < arr.length; i++){
				var label = arr[i];
        if(i < arr.length-1 && !label.match(/create|update|view/)){
					var url = host + arr[i];
          li += `<li><a href="${url}">${label}</a></li>\n`;
        }
        else li += `<li class="active">${label}</li>\n`;
        if(app.verbose) console.log(label, arr[i], url);
      }
      $('ul.breadcrumb').html('').append(li);
    },
    setScrollBtn: function(showSearch=true){
			if(app.verbose) console.log('> setScrollBtn ', window.scrollY, 'showSearch:', showSearch);
      if(window.scrollY - 100 > window.innerHeight) 
				$('#scrollUp').fadeIn();
      else $('#scrollUp').fadeOut();
			if(showSearch) app.handleSearchScroll();
    },
    scrollTop: function(){
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
		registerBtnScroll: function(showSearch=true){
			var t_scroll;
			if(app.verbose) console.log('> registerBtnScroll', t_scroll);
			window.onscroll = function(){
				clearTimeout(t_scroll);
				t_scroll = setTimeout(function(){app.setScrollBtn(showSearch)}, 300);
			};
		},
		handleSearchScroll: function(){
			if(app.verbose) console.log('> handleSearchScroll');
			var search_hdn = $('.selectize-control').is(':hidden');
			var search_ico = $('#search-ico');
			if(window.scrollY > 0 || search_hdn){
				search_ico.removeClass('glyphicon-zoom-out').addClass('glyphicon-zoom-in').attr('title', 'Show search');
				if(search_ico.is(':hidden'))
					search_ico.fadeIn(1000);
			}
			else{
				search_ico.removeClass('glyphicon-zoom-in').addClass('glyphicon-zoom-out').attr('title', 'Show search');
			}
			if(search_ico.length && !search_ico.is(':hidden')){
			$('#order_btn').animate({top: "250"}, 800);}
		},
		registerGridSorter: function(){
			$('.table tr th:not(.index, .action-column)').on('click', function(e){
				if(e.target.nodeName=='TH')
					$(this).children()[0].click();
			});
		},
		adjustPageSize: function(){
			var par = new URL(location.href);
			if(!par.searchParams.get('size')){
				var client_h = $(window).height();
				var size = Math.floor((client_h - 300)/31.40);
				if(size != app.pagesize) {
					if(size <= 0)
						size = 1;
					var url = app.rewrite_on ? location.href+'?size='+size : location.href+'&size='+size;
					if(app.verbose) 
						console.log('adjustPageSize.. win_h:',  $(document).height(), ' size:', size);
					$.pjax.reload({container:'#pjax-con', url:url, timeout:0, replace:0});
				} else {
					$('#pjax-con').css('opacity',1).addClass('animate__animated animate__fadeIn');
					return;
				}
			}else
				$('#pjax-con').css('opacity',1).addClass('animate__animated animate__fadeIn');
		},
		registerBtn: function(){
			$('a#create').on('click', function(e){
				e.preventDefault();
				$.pjax({url:this.href, container:'#pjax-con', push:false, timeout:0});
			});
			$('a#print').on('click', function(e){
				e.preventDefault();
				window.location=app.current_url() + '&print=1';
			});
		},
		registerBtnBack: function(el){
			el.on('click', function(e){
				console.log(e.target.href);
				e.preventDefault();
				if(window.onbeforeunload){
					if(!confirm('Changes you made may not be saved')) return;
				}
				app.pjax_goback();
			});
		},
		registerInputChange: function(){
			if(app.verbose) console.log('> registerInputChange');
			app.form_edited = false;
			var data = $('#order-form').serializeArray();
			var list=[], idx;
			function proc_list(key, edited){
				if(!edited && !list.length) return;
				if(list.find((v) => { return v==key })){
					idx = list.indexOf(key);
					if(edited){
						if(idx==-1)
							list.push(key);
					}else{
						list.splice(idx, 1);
					}
				}
				else if(edited) list.push(key);

				$('#order-form').yiiActiveForm('validateAttribute', key);
				if(app.verbose) console.log('edited:', edited, 'key:', key, 'idx:', idx);
			
				if(list.length){
					if(app.form_edited) return;
					$('.edited').fadeIn();
					$('#order-form button[type=submit]').attr('disabled', false);
					app.form_edited = true;
					window.onbeforeunload = function(){return 'Changes you made may not be saved';};
				}else{
					if(!app.form_edited) return;
					$('.edited').fadeOut();
					$('#order-form button[type=submit]').attr('disabled', true);
					app.form_edited = false;
					window.onbeforeunload=null;
				}
				if(app.verbose) console.log('> LIST:', list, 'form_edited:', app.form_edited);
			}
			
			$("#order-form [name^='Order']:not(:disabled)").off('change').on('change', function(){
				if(app.verbose) console.log('ON-CHANGE:', this.type, this.id, this.name, this.value, this.title);
				if(this.type=='file'){
					$('#file_a').val(this.value);
				}
				if(this.type=='select-one' && (this.id =='order-priority'||this.id =='order-type')){
					if(this.options[this.value])
						this.title = this.options[this.value].title;
				}
				if(data.find((o) => {return o.name==this.name && o.value==this.value.trim()})){
					proc_list(this.id);
				}else{
					proc_list(this.id, 1);  // ga ada dan show mark as edited
				}
			});
		},
		validate_attr: function(){
			if(app.verbose) console.log('validate_attr');
			$('#order-form').data('yiiActiveForm').attributes.forEach(function(obj){
				$('#order-form').yiiActiveForm('validateAttribute', obj.id); 
			});
		},
		registerSearchBtn: function(){
			if(app.verbose) console.log('> registerSearchBtn');
			var search = $('.selectize-control');

			$('#search-ico').off('click').on('click', function(){
				if(app.verbose) console.log('> search btn click');
				if(search.is(':hidden')){
					search.slideDown();
					$(this).removeClass('glyphicon-zoom-in').addClass('glyphicon-zoom-out').attr('title', 'Hide search');
					app.scrollTop();
					setTimeout(function(){searchOrder.focus()},500);
				}else{
					if(window.scrollY > 0){
						setTimeout(function(){searchOrder.focus()},500);
						return app.scrollTop();
					}
					search.slideUp();
					$(this).removeClass('glyphicon-zoom-out').addClass('glyphicon-zoom-in').attr('title', 'Show search');
				}
			});
		},
		switch_theme: function(e){
			if(app.verbose) console.log('switch_theme', $(this));
			var body = $('body');
			if($('#dark-mode').is(':checked')){
				body.removeClass('dark');
			}else{
				body.addClass('dark');
			}
		},
		registerAjaxForm: function(form){
			form.on('beforeSubmit', function (e, xhr, opt, a) {
				if(app.verbose) console.log('beforeSubmit', e, xhr, opt, a);
				$('button[type=submit]:not(.logout)').attr('disabled', true);
				if(form.find('input:file').val()){
					var data = new FormData(this);
					var cache = false; // def:true
					var contentType = false;
					var processData = false; // def:true
				}else{
					var data=$(this).serializeArray();
					var cache = true;
					var contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
					var processData = true;
				}

				$.ajax({
					type: $(this).attr('method'),
					url: $(this).attr('action'),
					data: data,
					cache: cache,
					contentType: contentType,
					processData: processData
				})
				.done(function(data, status, xhr) {
					var cur_url = app.current_url();
					if(app.verbose) console.log('AJAX-DONE DATA', data, cur_url, app.url_his, xhr, xhr.status, 'responseJSON:', xhr.responseJSON, 'responseText:', '"'+xhr.responseText+'"');
					if(data.success){
						window.onbeforeunload = null;
						if(cur_url.match(/create|update/)){
							if(data.msg){
								if(typeof data.msg=='object'){
									for (let key in data.msg) {
										app.storeMsg(data.msg[key].txt, data.msg[key].type);
									}
								}else app.storeMsg(data.msg, 'info');
							}
							if(cur_url.match(/order\/(update|create)/)){
								if(data.redirect){
									return app.pjax_goto(data.redirect);
								}
								var url = app.url_his.length > 1 ? app.url_his[0] : app.homeUrl();
								app.pjax_goto(url, true);
							}
							else app.pjax_goback();
						}
						else app.pjax_goback();
					}
					else {
						if(data.msg){
							if(typeof data.msg=='object'){
								for (let key in data.msg) {
									app.setMsg(data.msg[key], 'danger');
								}
							}
							else app.setMsg(data.msg, 'danger');
						}
						else if(xhr.responseText)
							$('#pjax-con').html(data);
						$('#order-form button[type=submit]').attr('disabled', false);
					}
				})
				return false; // prevent default form submission
			});
		},
	}
  return fn;
})(window.jQuery);

$(document).ready(function(){
  app.setUrlHis(location.href);
  app.setUser();
  $('#scrollUp').on('click', app.scrollTop);
  if(app.verbose) console.log('app.js READY FN...', "SCRIPT:" + app.getUrl().script);

  $(document)
  .on('pjax:start', function (e, xhr, opt) {
		$('#pjax-con').removeClass('animate__animated animate__fadeIn');
  })
  .on('ajaxStart', function (e, xhr, opt) {
    if(app.verbose) console.log('AJAX-START..');
    app.setLoader();
  })
  // .on('pjax:send', function (e, xhr, opt) {
    // console.log('PJAX SEND..', opt);
  // })
  .on('pjax:complete', function (e, res, status, req) {
    if(app.verbose) console.log('PJAX COMPLETE');
    $('#pjax-con').addClass('animate__animated animate__fadeIn');
		if(decodeURIComponent($.pjax.state.url).match(/\/create|\/update|\/view/))
			$('.report-attr').hide();
		else
			$('.report-attr').fadeIn();
    
    $('#scrollUp').fadeOut();
		if(!$.pjax.state.url.match('scroll'))
			app.setUrlHis($.pjax.state.url);
		if(document.querySelector('ul.breadcrumb'))
			app.getBreadcrumb();
  })
  .bind("ajaxError", function (e, xhr, response, error){
    if(app.verbose) console.warn('AJAX-ERROR xhr:', app.current_url(), error, xhr, 'status:', xhr.status, 'responseJSON:', xhr.responseJSON, 'responseText:', '"'+xhr.responseText+'"' /*JSON.stringify(xhr), JSON.stringify(response)*/ );
    if(xhr.status==302){
      if(xhr.getResponseHeader('X-Redirect')){
        var redirect = decodeURIComponent(xhr.getResponseHeader('X-Redirect'));
      }else{
        var redirect = decodeURIComponent(xhr.getResponseHeader('X-Pjax-Url'));
      }
      if(!redirect) return;
      var loginUrl = app.rewrite_on ? (app.homeUrl() + 'site/login') : app.homeUrl() + '?r=site/login';
      // console.log('Redirect', redirect, loginUrl);
      if(redirect == loginUrl) 
				$.notify('Your session has expired', {type:'warning'});
      return false;
    }
    if(xhr.responseJSON){
      app.setMsg(xhr.responseJSON.message, 'danger', xhr.responseJSON.name);
    }
    else if(xhr.responseText){
      app.setMsg(xhr.responseText.replace('<pre>','').substr(0, 200) +' ...', 'danger', xhr.responseText.statusText);
		}

		if(xhr.status == 400 || xhr.status == 403) window.location.reload();
		if(app.current_url().match(/order\/(update|create)/))
			$('#order-form button[type=submit]').attr('disabled', false);
  })
  .bind('ajaxStop', function (e) {
    if(app.verbose) console.log('AJAX-STOP..');
    app.removeLoader();
		app.getMsgs();
  });

	$('#dialog').modal({backdrop:'static', keyboard:false, show:false})
	.on('hidden.bs.modal', function(e){
		e.preventDefault();
		if(app.verbose) console.log('Dialog hidden');
	})
	.on('shown.bs.modal', function(){
		if(app.verbose) console.log('Dialog shown');
		$('#dialog input').trigger('focus');
	});
	
	$('.navbar-toggle').on('click', function(){
		var el = $('.navbar-fixed-top .navbar-collapse');
		if(app.verbose) console.log($(window).height()-57); 
		el.css('max-height', $(window).height()-57);
		// el.scrollTop(el[0].scrollHeight-el[0].offsetHeight);
	});
	$('.navbar-collapse .dropdown').click(function(){
		if($(this).hasClass('open')) return;
		setTimeout(function(){
			var el = document.querySelector('.navbar-fixed-top .navbar-collapse');
			var h = el.scrollHeight - el.offsetHeight;
			el.scrollTo({top: h, behavior: 'smooth'});
		}, 50);
	})
});

function renderOrder(item, isSearch){
	if(app.verbose) console.log('> renderOrder', isSearch, item);
	var kelas = (app.user.uid==item.assign_to || app.user.uid==item.initiator_id) ? item.statusText : '';
	// (isOwner && status < STATUS_ONPROGRESS) || (isAssigned && status > STATUS_REJECTED && !isComplete);
	var kelas = '';
	var uid = app.user.uid;
	if(item.status != 4 && ((uid==item.initiator_id && item.status < 3) || (uid==item.assign_to && item.status > 1)))
		kelas = item.statusText;
	if(item.status==3)
		kelas = 'inprogress';
	
  // var color = app.user.uid==item.assign_to && item.status==ST_OPEN ? 'red' : '';
	var str = isSearch ? '<div class="list clearfix">'
    : '<div class="list order '+kelas+' clearfix animate__animated animate__fadeIn" data-url="'+getOrderDataUrl(item)+'" data-key="'+item.id+'"> <div class="separator"># '+item.id+'</div>';
  if(isSearch)
		str +='<div class="form-group col-sm-2"> <label>Request No.</label> <div>'+ item.id +'</div> </div>';
	str +='<div class="form-group col-sm-2"> <label>Initiator</label> <div>'+ item.initiator_name +'</div> </div>'
  +'<div class="form-group col-sm-2"> <label>Departement</label> <div>'+ item.initiator_dept +'</div> </div>'
  +'<div class="form-group col-sm-2"> <label>Created</label> <div>'+ item.create_at +'</div> </div>'
  +'<div class="form-group col-sm-2"> <label>Assigned To</label> <div>'+ item.assignTo_name +'</div> </div>'
	+'<div class="form-group col-sm-2"> <label>Priority</label> <div>'+ item.priorityText +'</div> </div>'
	+'<div class="form-group col-sm-2"> <label>Status</label> <div>'+ item.statusText +'</div> </div>'
  +'<div class="form-group col-sm-2"> <label>Title</label> <div class="text">'+ sub_str(item.title,22) +'</div> </div>';
	if(isSearch)
		str +='<div class="form-group col-sm-8"><label>Request Descriptions</label><div class="text">'+ sub_str(item.detail_desc,110) +'</div></div></div>';
	else 
		str +='<div class="form-group col-sm-10"><label>Request Descriptions</label><div class="text">'+ sub_str(item.detail_desc,285) +'</div></div></div>';
  return str;
}

function getOrderDataUrl(item){
  var uid = app.user.uid;
	var action = 'view';
	if((uid==item.initiator_id && item.status < 3) || (uid==item.assign_to && item.status > 1))
		action = 'update';
  var path = app.rewrite_on ? ('order/'+action+'/'+item.id) : ('?r=order/'+action+'&id='+item.id);
  return app.homeUrl() + path;
}

function sub_str(str, max){
	if(str.length > max)
		return str.substr(0, max) +' ..';
	return str;
}

function makeDatePicker(el, grid){
	if(app.verbose) console.log('> makeDatePicker:', el, grid);
   var lp = new Litepicker({
    element: el,
    format: 'DD-MM-YYYY', // format: 'DD-MM-YYYY 00:00',
    maxDate: new Date(),
    resetButton: function(){
      let btn = document.createElement('button');
      btn.className = 'reset';
      // btn.setAttribute('disabled', 'disabled');
      btn.innerText = 'Clear';
      btn.addEventListener('click', (evt) => {
        evt.preventDefault();
        this.clearSelection();
        this.hide();
        if(grid) grid.yiiGridView('applyFilter');
      });
      return btn;
    },
  });
	
	if(grid){
		lp.on('render', (ui) => {
			if(app.verbose) console.log('RENDER PICKER..', ui);
			var reset = lp.ui.querySelector('.reset');
			if(lp.getDate()) reset.removeAttribute('disabled');
		})
		.on('selected', (d) => {
			if(app.verbose) console.log('SELECTED PICKER..', d);
			grid.yiiGridView('applyFilter');
		});
	}
  return lp;
}

function makeDatePickerForm(el, input){
	if(app.verbose) console.log('> makeDatePickerForm:', el);
	var lp = new Litepicker({
		element: el,
		// format: 'DD-MM-YYYY', // format: 'DD-MM-YYYY 00:00',
		format: {
			parse(date) {
				console.log('parse', date, (date instanceof Date));
				if (date instanceof Date) {
					return date;
				}
				return new Date(date);
			},
			output(date) {
				console.log('date:', date);
				return formatDate(date);
			}
		},
		// maxDate: new Date(),
		resetButton: function(){
			let btn = document.createElement('button');
			btn.className = 'reset';
			btn.innerText = 'Clear';
			btn.addEventListener('click', (evt) => {
				evt.preventDefault();
				this.clearSelection();
				this.hide();
			});
			return btn;
		},
	});

	lp.on('render',(ui) => {  console.log('RENDER PICKER', ui);
		lp.triggerElement.setAttribute('disabled', 'disabled');
	})
	.on('selected',(d) => {  console.log('SELECTED PICKER', d, lp.triggerElement.id);
		$('#order-form').yiiActiveForm('validateAttribute', lp.triggerElement.id);
		input.value = d.toDateString();
		input.dispatchEvent(new CustomEvent('change'));
		lp.triggerElement.removeAttribute('disabled');
	})
	.on('clear:selection', ()=> {  console.log('PICKER CANCEL');
		$('#order-form').yiiActiveForm('validateAttribute', lp.triggerElement.id);
		input.value = '';
		input.dispatchEvent(new CustomEvent('change'));
		lp.triggerElement.removeAttribute('disabled');
	})
	.on('hide', function() {
		console.log('PICKER HIDE');
		if(lp) lp.triggerElement.removeAttribute('disabled');
	});
	return lp;
}

function formatDate(date) {
	if(app.verbose) console.log('formatDate:', date);
  if(! date instanceof Date){
    date = new Date(date);
  }
  var month_str = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  var day_str = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
	var year = date.getFullYear();
	var daystr = day_str[date.getDay()];
  var monthstr = month_str[date.getMonth()];
  var dt = date.getDate();
  var hour = date.getHours();
  var min = date.getMinutes();
  var sec = date.getSeconds();
  return daystr + ', ' + dt + '-' + monthstr + '-'+ year;
}

function loadData(path, query, selectize, callback){  
	if(app.verbose) console.log('> LOAD-DATA', path, query);
  var homeUrl = app.homeUrl();
  var url = app.rewrite_on ? (homeUrl + path + '?q='+ query) : (homeUrl + '?r=' + path);

  $.ajax({
    url: url,
    type: 'POST',
		data: {q:query, offset:null},
    beforeSend: function(xhr){
      selectize.lock();
      selectize.$control.removeClass('focus');
    },
    error: function(xhr, status, error) {
      callback();
    },
    success: function(res) {
			if(app.verbose) console.log('ajax-res:', url, res.length);
			if(url.match(/order\/suggest/)){
				searchOrder.$btn_remove.fadeIn();
				if(!res.length) $('#q-result').show().text('Not Found');
			}
      selectize.unlock();
      callback(res);
    }
  });
}

function getSelectizeTag(el){
	if(app.verbose) console.log('> getSelectizeTag');
	var desc = $('#order-item_desc');
  var tag = el.selectize({
    placeholder: 'Search tag-number..',
    valueField: 'tagnum',
    labelField: 'tagnum',
    searchField: ['tagnum', 'desct'],
    options: [],
    maxItems: 1,
    //maxOptions: 3,
    create: false,
    preload: true,
    allowEmptyOption: false,
    addPrecedence: false,
    //loadThrottle: 1000,
    render: {
      option: function(item, escape) {
        if(item.id){
          return '<div class="selectize-list"> <span class="header">'
            +'<strong> <i class="glyphicon glyphicon-tags"></i>'+ item.tagnum +'</strong>'
            +', <span>'+ item.desct +',</span>'
          +'</span>'
          +'<span class="content clearfix">Area/Room: '+ escape(item.area) +'</span>'
          +'</div>';
        }else{
          return "<div class='selectize-list'> <span class='header'> <strong>"+ item.tagnum +"</strong> </span> </div>";
        }
      },
      item: function(item, escape) {
        return '<div>'+ item.tagnum +'</div>';
      },
    },
    load: function(query, callback) {
			if(app.verbose) console.log('SELECTIZE-load query:', query, this.getValue());
      query = query ? query : this.getValue();
      if (!query.length) return callback();
      loadData('order/tag-suggest', query, this, callback);
    },

    onInitialize: function(){
      var tagnum = this.getValue();
      var item = this.items[0];

      if(this.isFull()){
        var data = {id:item, tagnum:tagnum, desct:desc.val(), 
					area_id:$('#order-area_id').val(), area:$('#order-area').val()};
        this.options[item] = data;
        this.updateOption(item, data);
        if(tagnum != 'Other'){
          desc.attr('readonly','readonly');
        }
      }
			desc.keypress(function(event){
				if (event.which == '13'){
					event.preventDefault();
				}
			});
    },
    onItemAdd: function(value, item){
      var data = this.options[value]; 
			// if(app.verbose) console.log(`> TAG-onItemAdd value:${value} data:`, data, 'item:', item[0]);
      if(data && data.tagnum !='Other'){
        desc.val(data.desct).attr('readonly','readonly');
        areaSearch.setValue(data.area_id);
        areaSearch.lock();
      }else{
        this.trigger('item_remove');
      }
    },
    onItemRemove: function(value){
      if(app.verbose) console.log('TAG-onItemRemove value:', value);
      desc.val(null).removeAttr('readonly');
      $('#order-area_id').removeAttr('readonly');
      areaSearch.setValue();
      areaSearch.unlock();
    },
     onDropdownOpen: function(dropdown){
      if(app.verbose) console.log('TAG-onDropdownOpen dropdown:', this);
      if(!this.currentResults.total) this.onSearchChange(' ');
    },
		onBlur: function(){
      if(app.verbose) console.log('TAG-onBlur');
      this.$control_input.width('auto');
    }
  });
  return tag[0].selectize;
}

function getSelectizeUser(el){
	if(app.verbose) console.log('> getSelectizeUser');
  var user = el.selectize({
    placeholder: 'Select Assign To',
    valueField: 'id',
    labelField: 'uname',
    searchField: ['uname', 'fullname'],
    options: [],
    create: false,
    loadThrottle: 1000,
    render: {
      option: function(item, escape) {
        return '<div class="selectize-list"> <span class="header">' +
          '<strong> <i class="glyphicon glyphicon-user"></i>'+ item.uname +'</strong>' +
          (item.fullname ? ', <span class="email">'+ item.fullname +'</span>' : '') +
        '</span>' +
        '</div>';
      },
      item: function(item, escape) {
        return '<div>'+ item.uname + (item.fullname ? ', '+item.fullname : '') + '</div>';
      },
    },
    load: function(query, callback) {
      if (!query.length) return callback();
      loadData('order/user-suggest', query, this, callback);
    },
    onInitialize: function(){
      var id = this.items[0];
      var uname = $('#order-assignto_name').val();
      var fullname = $('#order-assignto_fullname').val();
			var dept = $('#order-assignto_dept').val();

      if(this.isFull()){
				if(app.verbose) console.log('>> has user in the input..');
        var data = {id:id, uname:uname, fullname:fullname, dept:dept};
        this.options[id] = data;
        this.updateOption(id, data);
      }
      // console.log(`USER - onInitialize - id:${id}, fullname:${fullname} data:`, 'data', this);
    },
  });
  return user[0].selectize;
}

function getSelectizeArea(el){
	if(app.verbose) console.log('> getSelectizeArea');
  var area = el.selectize({
    placeholder: 'Search Area..',
    valueField: 'id',
    labelField: 'area',
    searchField: 'area',
    maxItems: 1,
    options: [],
    create: false,
    preload: true,
    allowEmptyOption: false,
    addPrecedence: false,
    onItemAdd: function(value, item){
      if(app.verbose) console.log(`> AREA-SEARCH onItemAdd value:${value}`,'item:', item);
    },
    onChange: function(value){
      var data = this.options[value]; 
			if(app.verbose) console.log(`AREA-onChange value:${value} ${typeof value}, data:`, data, value==='0');
      if(value){
        if(value != 'other'){
					$('#addArea').fadeOut();
					$('#date_time').removeClass('clear');
        }else{
					$('#addArea').fadeIn();
					$('#date_time').addClass('clear');
				}
        if(data.area != 'Other') $('#order-area').val(data.area);
      }else{
        $('#order-area').val(value);
      }
    },
    onDropdownOpen: function(dropdown){
      if(app.verbose) console.log('AREA-onDropdownOpen dropdown:', this);
      if(!this.currentResults.total) this.onSearchChange(' ');
    },
    onInitialize: function(){

    },
    onLoad: function(data){
      if(tagSearch){
        var tag = tagSearch.getValue();
        if(tag && tag != 'Other') this.lock();
      }
    },
    onBlur: function(){
      if(app.verbose) console.log('AREA-onBlur');
      this.$control_input.width('auto');
    },
  });
  return area[0].selectize;
}

// order form fn
function regionSelectHandler(){
  $('#order-region_id').change(function(){
    var id = this.options.selectedIndex;
    var param = app.rewrite_on ? 'create/'+id : 'create&region='+id;
    var url = $('#region-link').attr('href').replace(/create(|\/\w+)$/, param);

    if(app.verbose) console.log('> regionSelectHandler', id, url );
    $('#region-link').attr('href', url).removeClass('disabled').addClass('active');
  });
}

function reg_form_ctrl(){
	if(app.verbose) console.log('> reg_form_ctrl (for initiator)');
	regionSelectHandler();
	$('.region_assigned .link.clickable').on('click', function(){
		$('.region_form').toggle();
	});
	$('.q_ass .yes, .q_ass .no').on('click', function(a){
		var v = $(this).hasClass('yes') ? 2 : 1;
		set_checkmark(v, false);
	});
	var ehs_hazard = $('#order-ehs_hazard');
	var ehs_hazard_risk = $('#order-ehs_hazard_risk');
	$('#order-ehs_assest').on('change', function(){
		var id = this.options.selectedIndex;
		if(app.verbose) console.log('order-ehs_assest change:', id);
		if(id) {
			ehs_hazard.attr('disabled', false);
		} else {
			ehs_hazard.attr('disabled', true).val(1).trigger('change');
		}
	});
	ehs_hazard.on('change',function(){
		if(this.options.selectedIndex) {
			ehs_hazard_risk.attr('disabled', false);
		} else {
			ehs_hazard_risk.attr('disabled', true).val(null).trigger('change');
		}
	});
	if(ehs_hazard.val()==1)  // disable ehs_hazard_risk
		ehs_hazard.trigger('change');
}

function reg_st_chg(isAssigned=false){
	if(app.verbose) console.log('> reg_st_chg isAssigned:', isAssigned);
	var complete_at_attr = $('#order-form').yiiActiveForm('find', 'order-complete_at');
	var complete_h_attr = $('#order-form').yiiActiveForm('find', 'order-complete_hours');
	
	$('#order-status').on('change', (ev)=>{
		if(app.verbose) console.log('> reg_st_chg value:', ev.target.value);
		var form = $('#order-form');
		if(isAssigned){
			if(ev.target.value==1){
				$('#complete_at').attr('disabled', true).val(null);
				$('#order-complete_at').attr('disabled', true).val(null);
				$('#order-complete_hours').attr('disabled', true).val(null);
				$('#order-replacement').attr('disabled', true).val(null);
				$('#order-attachment').attr('disabled', true).val(null);
				$('#order-complete_at_sys').val(null);
				form.yiiActiveForm('updateAttribute', 'order-complete_at','');
				form.yiiActiveForm('updateAttribute', 'order-complete_hours','');
				form.yiiActiveForm('updateAttribute', 'order-attachment','');
				form.yiiActiveForm('updateAttribute', 'order-replacement','');
				form.yiiActiveForm('remove', 'order-complete_at');
				form.yiiActiveForm('remove', 'order-complete_hours');
				// form.yiiActiveForm('remove', 'order-attachment');
			}
			else if(ev.target.value==4){
				$('#complete_at').attr('disabled', false); 
				$('#order-complete_at').attr('disabled', false); 
				$('#order-complete_hours').attr('disabled', false);
				$('#order-attachment').attr('disabled', false);
				$('#order-replacement').attr('disabled', false);
				$('#order-complete_at_sys').val(formatDate(new Date()));
				form.yiiActiveForm('add', complete_at_attr);
				form.yiiActiveForm('add', complete_h_attr);
				// form.yiiActiveForm('add', attachment_attr);
			}
		}
	});
}

function setStatusClr(){
	let v = $('#order-status option:selected').val();
	if(v==1)
		$('#order-status').css('color', 'red');
	else if(v==3)
		$('#order-status').css('color', 'green');
}

function set_checkmark(v, disabled){
if(app.verbose) console.log(`> set_checkmark v:${v} disabled:${disabled}`);
	var input = document.getElementById('order-quality_ass');
	// if(!input.length) return;
	if(v=='') v = 1;
	if(v==2){
		$('.q_ass .yes').find(':first').addClass('active').next().find('input').prop('checked', true);
		$('.q_ass .no').find(':first').removeClass('active').next().find('input').prop('checked', false);
		$('#order-mmnr').prop('disabled', false).parent().removeClass('disabled');
	}else{
		$('.q_ass .yes').find(':first').removeClass('active').next().find('input').prop('checked', false);
		$('.q_ass .no').find(':first').addClass('active').next().find('input').prop('checked', true);
		$('#order-mmnr').prop('disabled', true).val(null).parent().addClass('disabled');
		$('#order-form').yiiActiveForm('validateAttribute', 'order-mmnr');
	}
	// $(input).val(v).trigger('change');
	if(disabled) $('.q_ass').addClass('disabled').find('input').prop('disabled',true);
	input.value = v;
	input.dispatchEvent(new Event('change'));
}

function reg_btn_approval(){
	if(app.verbose) console.log('> reg_btn_approval');
	var form = $('#order-form');
	$('#reject-btn').on('click', function(e){
		e.preventDefault();
		$('#order-status').val(1);
		form.yiiActiveForm('validateAttribute', 'order-comment'); 
		setTimeout(function(){
			if(form.find(".has-error").length) {
				return false;
			}
			if(confirm('Reject this request?'))
				form.submit();
		}, 200);
	});
	$('#accept-btn').on('click', function(e){
		e.preventDefault();
		$('#order-status').val(3);
		form.yiiActiveForm('updateAttribute', 'order-comment','');
		form.yiiActiveForm('remove', 'order-comment'); 
		form.submit();
	});
}

function reg_btn_submit(){ // only status 2 & 3
	if(app.verbose) console.log('> reg_btn_submit');

	$('#submit').on('click', function(e){
		e.preventDefault();
		var form = $('#order-form');
		var ls = form.find("[name^='Order']:not(:disabled)");
		ls.map(function(i){
			$('#order-form').yiiActiveForm("validateAttribute", this.id);
		});
		setTimeout(function(){
			var err = form.find(".has-error");
			if(err.length) {
				$(window).scrollTop(err[0].offsetTop - err[0].offsetHeight);
				return false;
			}
			if($('#order-status').val()==1){
				if(!confirm('Do you want to cancel this request?')) return false;
			}
			else if($('#order-status').val()==4){
				if(!confirm('Click ok to complete this request')) return;
			}
			form.submit();
		}, 200);
	});
}

function reg_selectize(){
	tagSearch = getSelectizeTag($('#order-tag_num'));
	areaSearch = getSelectizeArea($('#order-area_id'));
	userSearch = getSelectizeUser($('#order-assign_to'));
	areaSearch.settings.load = function(query, callback) {
		loadData('order/area-suggest', query, this, callback);
	}
	userSearch.on('change', function(value){
		var data = this.options[value];
		if(!data) data = {id:'', uname:'', fullname:'', email:'', dept:''}
		if(app.verbose) console.log(`onChange value:${value} ${typeof value}, data:`, data, value==='0');
		$('#order-assignto_dept').val(data.dept);
		$('#order-assignto_email').val(data.email);
		$('#order-assignto_name').val(data.uname);
		$('#order-assignto_fullname').val(data.fullname);
	});
}

function reg_comment_view(){
	if(app.verbose) console.log('> reg_comment_view');
	var ctrl = $('#view-cmt');
	var con = $('#comment_list');
	ctrl.on('click', function(){
		if(app.verbose) console.log(`toggle ${con.hasClass('full')} ${con[0].offsetHeight}/${con[0].scrollHeight}`, this.hash);
		if(con.hasClass('full')){
			ctrl.text('Show More');
			con.removeClass('full');
		}else{
			ctrl.text('Show less');
			con.addClass('full');
		}
		$('.comment_box:not(.last)').animate({height:'toggle'});
	});
}

function createCommentForm(label='New Comment', isMandatory=false){
	if(app.verbose) console.log('> createCommentForm label:', label, 'isMandatory:', isMandatory);
	$('#new-cmt-con')
	.html('<label class="control-label" for="order-comment">'+label+'</label><textarea id="order-comment" class="form-control" name="Order[comment]" rows="4" spellcheck="false"></textarea><div class="help-block"></div>')
	.slideDown();
	if(isMandatory)
		$('#order-form').yiiActiveForm('add', ({'id':'order-comment','name':'comment','container':'.field-order-comment','input':'#order-comment','validate':function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {'message':'Comment cannot be blank.'});yii.validation.string(value, messages, {'message':'Comment must be a string.','max':500,'tooLong':'Comment should contain at most 500 characters.','skipOnEmpty':1});}}));
	app.registerInputChange();
}

function reg_comment_add(){
	if(app.verbose) console.log('> reg_comment_add');
	var cmt_con = $('#new-cmt-con');
	$('#new-cmt').on('click', function(){
		if(cmt_con.is(':hidden')){
			createCommentForm();
			setTimeout(function(){
				window.scrollTo({top:$(document).height(), behavior:'smooth'});
			}, 300);
			$(this).text('Cancel');
		}else{
			$('#order-comment').val(null).trigger('change');
			$('#order-form').yiiActiveForm('remove', 'order-comment');
			cmt_con.slideUp().removeClass('has-error');
			setTimeout(function(){cmt_con.html('')}, 500);
			$(this).text('Add Comment');
		}
	});
}

function getTypeLegend(){
	var url = app.rewrite_on ? 'order/get-type-legend' : 'index.php?r=order/get-type-legend';
	$.get(app.root+url, function(data){
		if(data){
			var el = document.getElementById('order-type');
			for(var i=0; i < el.children.length; i++){
				if(i != 0){
					el.children[i].title = data[i];
				}
			}
		}
		else app.setMsg(data.msg, 'warning');
  }, 'json');
}

function getLegend(){
	getTypeLegend();
	let p = {1:'Material order, setting/trial, project (Tag Number Others)', 2:'RO Recomendasi dari HIRA/Operator care/ Gemba EHS', 3:'Direct impact to Safety, Quality, Supply, Financial (Reactive)'}
	var el = document.getElementById('order-priority');
	for(var i=0; i < el.children.length; i++){
		if(i != 0){
			el.children[i].title = p[i];
		}
	}
}

function getSearchList(){
	if(app.verbose) console.log('> getSearchList');
	var scroll_to;

	window.onscroll = function(){
		if(searchOrder.isOpen) return;
    clearTimeout(scroll_to);
    scroll_to = setTimeout(function(){
      app.setScrollBtn();
      if(app.current_url() != app.homeUrl()) return;

			w_bottom = Math.round($(document).height() - this.innerHeight);
			w_pos = Math.ceil(this.scrollY);

			if(app.verbose) console.log('WINDOW-SCROLL', app.getUrl().script, 'w_pos:', w_pos, 'w_bottom:', w_bottom);
      if (w_pos >= w_bottom) {
        if(app.verbose) console.log(`Touch w_bottom.. offset:${offset} total:${total} w_pos:${w_pos} w_bottom:${w_bottom}`);
        if (offset <= total) {
          $(window).scrollTop(w_pos-5);
          if(app.loaderActive) return;
          var path = app.rewrite_on ? '/order/suggest' : '?r=order/suggest';
          $.ajax({
            url: app.homeUrl() + path,
            type: 'post',
            data: {offset:offset},
            success: function (data) {
              if(app.verbose) console.log('ajax success', data);
              if (data.length) {
                var content = '';
                data.forEach(function (obj, key) {
                  content += renderOrder(obj);
                });
                $('.list.order:last').after(content);
                $('.list.order').on('click', app.openOrder);
                offset = offset + data.length;
              } else {
                if(app.verbose) console.log('no data..');
                $('#no-data').fadeIn();
              }
            },
          });
        }
      }
    }, 300);
  };
	
	Selectize.define('enter_key_submit', function(options){
		var self = this;
		this.onKeyDown = (function (e) {
			var original = self.onKeyDown;
			return function (e) {
				if (e.keyCode === 13 && self.currentResults.query !== '') {
					// e.preventDefault();
					if (this.$activeOption && this.currentResults.total) {
						if(app.verbose) console.log('PRESS ENTER & HAS OPTIONS', this.$activeOption);
						this.onOptionSelect({currentTarget: this.$activeOption});
					}
				}
				return original.apply(this, arguments)
			}
		})();

		// this.last_query = document.getElementById('last_query').value;
		this.last_input;
		this.input = this.$input.val();
		this.submit = function(value){
			if(app.loaderActive) return;
			if(app.verbose) console.log('SUBMIT value:'+value+' input:'+this.input);
			this.$btn_remove.fadeIn();
			if(value !== this.input){
				this.input = value;
				var item = this.options[value];
				if(!item) {
					if(app.verbose) console.log('NO ITEM SELECTED');
					return;
				}
				if(app.verbose) console.log('SUBMIT SELECTED:\"'+value+'\" item:', item, {lastQuesr:this.lastQuery,'real-input':this.input, 'fake-input':this.$control_input.val()});
				var url = getOrderDataUrl(item);
				// event.preventDefault();
				this.setTextboxValue(value);
				return $.pjax({url:url, container: '#pjax-con', push:false, timeout:0});
			}
		}
		this.setInputReady = function(){
			if(app.verbose) console.log('> setInputReady');
			this.unlock();
			// if(this.isFull()){   console.log('>>normalize the input..');
				// var item = this.items[0];
				// // this.setTextboxValue(item);
				// this.showInput();
				// // this.removeItem(item);
			// }
		}
		this.hapus = function(el) {
			this.print_verbose('Hapus..');
			this.switch_listview(1);
			self.$btn_remove.fadeOut();
			if(self.items.length) {
				self.clear();
			} else {
				self.input = '';
				self.setTextboxValue('');
				self.updatePlaceholder();
			}
			if(window.onbeforeunload){
				if(!confirm('Changes you made may not be saved')) return;
			}
			if(app.url_his.length > 1) app.pjax_goto();
		}
		this.print_verbose = function(label, ...args){
			if(app.verbose) console.log(label, {total:(this.currentResults ? this.currentResults.total:undefined), isFocused:this.isFocused, 
			loader:app.loaderActive, real_input:this.input, ctrl_input:this.$control_input.val(), lastQuery:this.lastQuery, 
			lastValue:this.lastValue, full:this.isFull(), isLocked:this.isLocked, isBlurring:this.isBlurring, 
			isDisabled:this.isDisabled}, ...args);
		}
		this.switch_listview = function(show){
			if(show){
				$('#q-result').fadeOut();
				setTimeout(function(){
					$('#listview').css('opacity', 1);
					$('.list.order').on('click', app.openOrder).css('cursor', 'pointer');  // this.isFocused
				},500);
			}else{
				$('#listview').css('opacity', 0);
				$('.list.order').unbind('click').css('cursor', 'not-allowed');
			}
		}
	});

	var search = $('#search').selectize({
		plugins: [
			'enter_key_submit',
			'restore_on_backspace',
		],
		placeholder: 'Search ..',
		valueField: 'id',
		labelField: 'id',
		searchField: ['id', 'title', 'detail_desc', 'create_at'],
		options: [],
		loadThrottle: 1000,
		maxItems: 1,
		createOnBlur: true,
		persist: false,
		selectOnTab: false,
		allowEmptyOption: false,
		addPrecedence: false,
		// allowEmptyOption: true,
		// closeAfterSelect: true,
		load: function (query, callback){
			if (!this.lastQuery || query==this.input) return callback();
			if(app.verbose) console.log('LOAD query:\"'+ query +'\"','lastQuery:\"'+this.lastQuery+'\" input:\"'+this.input+'\"');
			this.$btn_remove.hide();
			loadData('order/suggest', query, this, callback);
		},
		render: {
			option: function (item, escape){ //console.log('RENDER-OPTIONS item:', item);
				return renderOrder(item, true);
			},
			// item: function(item, escape) {  console.log('render item:', item);
				// return ('<div class=\"item\">'+ item.title +'</div>');
			// },
			option_create: function (input){
				this.last_input = input.input;
				if(app.verbose) console.log('OPTION_CREATE', input, 'input:', this.input, 'last_input:',this.last_input, 'ctrl_input:', this.$control_input.val());
				if(this.currentResults.total > 0){
					return '<div id="result">Found ' + this.currentResults.total + ' matching order</div>';
				}
				// else if(input.input != this.input){
					// return '<div id="result">Searching ' + input.input + '..</div>';
				// }
				else if(this.loadedSearches[input.input])
					return '<div id="result">Not Found..</div>';
				else 
					return '<div id="result">Searching ' + input.input + '..</div>';
			},
		},
		create: function (input, callback){
			this.print_verbose('CREATE:', 'input:', input);
			// this.submit(input);
		},
		onChange: function (value){
			this.print_verbose('onChange', 'value:', value);
			if(value) this.submit(value);
		},
		onFocus: function () {
			this.print_verbose('onFocus');
			this.setInputReady();
			// if(this.currentResults && this.currentResults.total==0){  console.log('reload value');
				// var i = this.input;
				// delete searchOrder.loadedSearches[i];
				// this.input='';
				// this.onSearchChange(i);
				// //setTextboxValue
			// }
			//this.enable();
		},
		onBlur: function () {
			this.switch_listview(1);
			this.print_verbose('onBlur');
		},
		onDestroy: function () {
			this.print_verbose('onDestroy');
		},
		onInitialize: function () {
			this.print_verbose('onInitialize');
			this.$control_input.attr('autocomplete', 'off');
			this.$control.before('<a href="javascript:void(0)" class="remove" title="Remove / Back" onclick="searchOrder.hapus(this)">&times;</a>');
			this.$btn_remove = $("a.remove");
			this.$control.after('<div class="input-line-loader"></div> <div id="q-result"></div>');
			this.$line_loader = $(".input-line-loader-con");
		},
		onDropdownOpen: function (dropdown) {
			this.print_verbose('onDropdownOpen');
			this.setInputReady();
			this.switch_listview();
			if(this.isFull()){
				// setTimeout(function(){
					if(app.verbose) console.log('>>normalize the input..', searchOrder.items[0], this.getValue(), this.getTextboxValue());
					searchOrder.setTextboxValue(this.getValue());
					searchOrder.setValue();  // searchOrder.options['01092023001']
					searchOrder.showInput();
					searchOrder.focus();
					// // var item = this.items[0];
					// // this.removeItem(item);
				// }, 400);
			}
		},
		onDropdownClose: function (dropdown) {
			this.print_verbose('onDropdownClose');
			if(!this.isFocused) this.switch_listview(1);
		},
		// onType: function (str) {},
	});

	searchOrder = search[0].selectize;
	searchOrder.setValue();
	searchOrder.setTextboxValue();
	app.registerSearchBtn();
}

// function prom(name) {
  // return new Promise((resolve, reject) => {
    // var form = $('#order-form');
		// var ls = $("#order-form [name^='Order']:not(:disabled)");
		// ls.map(function(i){
			// $('#order-form').yiiActiveForm("validateAttribute", this.id);
			// console.log(i);
			// if(i==ls.length-1){
				// setTimeout(()=>{
					// var len = form.find(".has-error").length;
					// console.log(i, 'done'); 
					// resolve(len);
				// },100);
			// }
		// });

  // })
	// .then((len)=>{
		// console.log('len:', len);
		// if(len) { alert(1);
			// return false;
		// }
		// if($('#order-status').val()==1){
			// if(!confirm('Do you want to cancel this request?')) return false;
		// }
		// else if($('#order-status').val()==4){
			// if(!confirm('After completion this request will be archived. continue?')) return;
		// }
		// $('#order-form').submit();
	// });
// }

// function getStatusText(st){
  // let status = {1:'Rejected', 2:'Open', 3:'In-Progress', 4:'Closed'};
	// return status[st];
// }
// function getPriorityText(pr){
  // let priority = {1:'Low', 2:'Medium', 3:'High'};
	// return priority[pr];
// }
// function formatDate(date) {
  // if (!date) return;
  // var day, month, year;
  // d = date.split('-');
  // return new Date(d[2] + " " + d[1] + " " + d[0]);
// }