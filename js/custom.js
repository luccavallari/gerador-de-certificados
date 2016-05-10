$(document).ready(function(){
	$('.confirm').on('click', function () {
        return confirm('confirm?');
    });

    if( typeof DataTable == 'function' )
   		$('.dataTable').DataTable();

	$('#id_course').change(function(e){
		e.preventDefault();
		content  = $('.class_content');
		console.log('loading...');
		content.html('<center><img src="../images/loading.gif"></center>');
		if( $('#id_course').val() == "" ){
			content.html('');
			return;
		}
		$.getJSON(BASE_URL + 'admin/get_classes/' + $('#id_course').val(), function(data) {
			h = "<form method='POST' onsubmit='return updateForm()' id='form_rel_classes' action='"+BASE_URL+"admin/add_students_class'><div class='row'>";
				//students to add
				h += "<div class='col-md-6 divstud'>";
					h += "<h3><?=base_url()?></h3>";
					h += "<ul>";
					for (var i = 0 ; i < data.students_to_add.length ; i ++) {
						h += "<li onclick='selStud(this)' class='iteml desm' id='"+data.students_to_add[i].id+"'><span>"+data.students_to_add[i].name+"</span></li>";
					}
					h += "</ul>";
				h += "</div>";
				//added students
				h += "<div class='col-md-6 divstud'>";
				if( data.students_added.length == 0 ){
					h += "<h3 style='color: #ddd'><center>--</center></h3>";
				}else{
					h += "<ul>";
					for (var i = 0 ; i < data.students_added.length ; i ++) {
						h += "<li id='added"+data.students_added[i].id_reg+"' class='added"+data.students_added[i].id_reg+" itemladded alert alert-info'>"+data.students_added[i].name+"<span class='spanremove' onclick='removeFromClass("+data.students_added[i].id_reg+")' class='pull-right' title='delete'>X<span></li>";
					}
					h += "</ul>";
				}	
				h += "</div>";
			h += "</div>";
			h += "<div clas='row' style='text-align: center;'>";
			//inputs to send
			h += "<input name='id_course' value='"+$('#id_course').val()+"' type='hidden'>";
			h += "<input name='id_student_ar' id='id_student_ar' value='' type='hidden'>";//see updateForm() function
			h += "<input class='btn btn-primary' style='margin-top: 10px;' type='submit' value='"+$('#update_lang').val()+"'>"
			h += "</div></form>";
			content.html(h);
		});
	});		
});//document ready
//select student
function selStud(ob) {
	if( $(ob).hasClass('desm') ){
		//select
		$(ob).removeClass('desm');
		$(ob).addClass('marc');
		$(ob).addClass('btn');
		$(ob).addClass('btn-info');
		console.log('select ---> '+$(ob).attr('id'));
	}else{
		//unselect
		$(ob).removeClass('marc');
		$(ob).removeClass('btn');
		$(ob).removeClass('btn-info');
		$(ob).addClass('desm');
		console.log('unselect');
	}
};
function updateForm() {
	var it = [];
	$('.iteml').each(function(index) {
		if ( $(this).hasClass('marc') ) {
			it.push($(this).attr('id'));
		}
	});
	it_st = ( JSON.stringify(it) );
	//add to input
	$('#id_student_ar').val(it_st);
}
function removeFromClass(id){
	if ( typeof id != "undefined" ){

		//hide first
		$('.added'+id).hide(200);
		$.getJSON(BASE_URL + 'admin/remove_from_class/' + id, function(data) {
			console.log('ok');
		});
	}
}

//open modal to edit the main description.
$('.open_edit_cert_text').click(function(){
	$('#modalCertDesc').modal();
	id = $(this).attr('id').replace('desc__', '');
	console.log('Open: '+id);
	$('#form_alter_desc_cert').append('<img src="'+BASE_URL+'images/loading.gif" id="loading_image">');
	$('#form_alter_desc_cert').prepend('<input type="hidden" name="id" value="'+id+'">');


	//get description.
	$.ajax({
        url: BASE_URL+"admin/get_cert_description/"+id,
        type: 'POST',
        dataType: "HTML",
        success: function( response ) {
        	console.log('val: '+response);
        	//$('#long_description_ta').val(response);
        	tinyMCE.activeEditor.setContent(response);
        	$('#loading_image').remove();

        },
        error: function(e,textStatus, errorThrown) {
        	$('#modalCertDesc').modal('hide');
        	console.log("ERROR");        
        }
    });
});