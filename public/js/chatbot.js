document.addEventListener('DOMContentLoaded',()=>{
 const panel=document.querySelector('[data-chat]'),toggle=document.querySelector('[data-chat-toggle]');
 if(!panel||!toggle)return;
 panel.innerHTML='<header class=chat-head><div><small>ASISTENTE EDUCATIVO</small><strong>OrientaBot</strong></div><button type=button data-chat-close aria-label=Cerrar>×</button></header><div class=chat-messages data-chat-messages aria-live=polite></div><form class=chat-form data-chat-form><textarea name=message maxlength=500 required placeholder=Escribe_tu_consulta aria-label=Consulta></textarea><button type=submit aria-label=Enviar>➜</button></form><small class=chat-disclaimer>Las respuestas se basan en los datos de OrientaBo. Confirma información sensible con la institución.</small>';
 const messages=panel.querySelector('[data-chat-messages]'),form=panel.querySelector('[data-chat-form]'),input=form.elements.message,send=form.querySelector('button');
 input.placeholder='Pregunta sobre carreras o instituciones...';
 const history=[];
 const add=(text,role)=>{const item=document.createElement('div');item.className='chat-message '+role;item.textContent=text;messages.appendChild(item);messages.scrollTop=messages.scrollHeight;return item;};
 add('¡Hola! Puedo ayudarte a explorar carreras, universidades, institutos, cursos y el test vocacional. ¿Qué quieres conocer?','model');
 toggle.addEventListener('click',()=>{panel.hidden=false;setTimeout(()=>input.focus(),50);});
 panel.querySelector('[data-chat-close]').addEventListener('click',()=>panel.hidden=true);
 input.addEventListener('keydown',event=>{if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();form.requestSubmit();}});
 form.addEventListener('submit',async event=>{
  event.preventDefault();const message=input.value.trim();if(message.length<2||send.disabled)return;
  add(message,'user');input.value='';send.disabled=true;const loading=add('Consultando la información educativa…','model loading');
  try{
   const response=await fetch('/chatbot',{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]')?.content||''},body:JSON.stringify({message,history:history.slice(-6)})});
   const data=await response.json();loading.remove();
   if(!response.ok)throw new Error(data.message||'No pude completar la consulta.');
   add(data.answer,'model');history.push({role:'user',text:message},{role:'model',text:data.answer});if(history.length>6)history.splice(0,history.length-6);
  }catch(error){loading.remove();add(error.message||'Ocurrió un problema. Inténtalo nuevamente.','error');}
  finally{send.disabled=false;input.focus();}
 });
});
