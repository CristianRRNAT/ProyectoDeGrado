(() => {
 const institutionImages=document.createElement('script');institutionImages.src='/js/institution-images.js';document.head.appendChild(institutionImages);
 const badgeStyle=document.createElement('style');
 badgeStyle.textContent='.institution-badge{width:116px;height:116px;flex:0 0 116px;padding:10px;border:6px solid #20b486;border-radius:8px;box-sizing:border-box;overflow:hidden;box-shadow:none}.institution-badge img{display:block;width:100%;height:100%;object-fit:contain}.map-actions{display:flex;gap:9px;flex-wrap:wrap;justify-content:flex-end;align-items:end}.route-location-select{display:grid;gap:4px;color:#64716d;font-size:8px;font-weight:800}.route-location-select select{height:38px;max-width:245px;border:1px solid #cddbd6;border-radius:7px;background:#fff;color:#18372e;padding:0 9px;font-size:10px}.route-activate{border:0;background:#20b486;color:#fff;font-size:11px}.route-activate:disabled{opacity:.65;cursor:wait}.route-status{width:100%;margin:10px 0 0!important;padding:10px 12px;border-radius:7px;background:#eef7f4;color:#315d50!important;font-size:10px!important}.route-status.error{background:#fff0ef;color:#9e3128!important}@media(max-width:600px){.institution-badge{width:88px;height:88px;flex-basis:88px;padding:7px;border-width:5px;border-radius:7px}.map-actions{justify-content:flex-start;margin-top:18px}.map-actions .map-external{margin-top:0}.route-location-select{width:100%}.route-location-select select{max-width:none;width:100%}}';
 document.head.appendChild(badgeStyle);
 const locations=window.institutionMapData||[],about=document.querySelector('.main-column .info-card');
 if(locations.length>1){
  const heroDescription=document.querySelector('.institution-heading p'),institutionName=document.querySelector('.institution-heading h1')?.textContent?.trim()||'Esta institución';
  if(heroDescription)heroDescription.textContent=`${institutionName} cuenta con ${locations.length} sedes registradas en Bolivia.`;
  const addressLine=document.querySelector('[data-address-line]'),addressLocation=document.querySelector('[data-address-location]'),placeAddress=document.querySelector('.map-place-card span'),placeLink=document.querySelector('.map-place-card a');
  if(placeAddress)placeAddress.textContent='Escoge una ubicación de una sede';
  if(placeLink){placeLink.textContent='Selecciona una sede para ver su ubicación';placeLink.removeAttribute('target');placeLink.href='#institution-map';}
  const selectLocation=index=>{const location=locations[index];if(!location)return;if(addressLine)addressLine.textContent=location.display_address||location.address;if(addressLocation)addressLocation.textContent=[location.city,location.department].filter(Boolean).join(', ');if(placeAddress)placeAddress.textContent=[location.display_address||location.address,location.city,location.department].filter(Boolean).join(', ');if(placeLink){placeLink.textContent='Ver esta sede en Google Maps';placeLink.href='https://www.google.com/maps/search/?api=1&query='+encodeURIComponent(location.address);placeLink.target='_blank';}document.querySelectorAll('.institution-campus-list a').forEach((item,itemIndex)=>item.classList.toggle('is-selected',itemIndex===index));const routeSelect=document.querySelector('.route-location-select select');if(routeSelect)routeSelect.value=String(index);document.querySelector('.contact-address')?.scrollIntoView({behavior:'smooth',block:'center'});};
  const campusLinks=[...document.querySelectorAll('.institution-campus-list a')];
  campusLinks.forEach((link,index)=>{link.removeAttribute('target');link.removeAttribute('rel');link.href='#';link.setAttribute('role','button');link.addEventListener('click',event=>{event.preventDefault();selectLocation(index);});});
  if(campusLinks.length>8){
   campusLinks.slice(8).forEach(link=>link.hidden=true);
   const campusList=document.querySelector('.institution-campus-list'),openButton=document.createElement('button'),modal=document.createElement('div'),dialog=document.createElement('div'),header=document.createElement('div'),modalGrid=document.createElement('div'),closeButton=document.createElement('button');
   openButton.type='button';openButton.className='campus-show-all';openButton.textContent=`Ver todas las sedes (${campusLinks.length})`;
   modal.className='campus-modal';modal.hidden=true;dialog.className='campus-modal-dialog';header.className='campus-modal-header';modalGrid.className='campus-modal-grid';closeButton.type='button';closeButton.className='campus-modal-close';closeButton.setAttribute('aria-label','Cerrar');closeButton.textContent='×';
   const heading=document.createElement('div'),eyebrow=document.createElement('small'),title=document.createElement('h3');eyebrow.textContent='PRESENCIA INSTITUCIONAL';title.textContent='Todas las sedes registradas';heading.append(eyebrow,title);header.append(heading,closeButton);
   locations.forEach((location,index)=>{const item=document.createElement('button'),name=document.createElement('b'),detail=document.createElement('small');item.type='button';item.className='campus-modal-item';name.textContent=location.name;detail.textContent=[location.city,location.department].filter(Boolean).join(' · ');item.append(name,detail);item.addEventListener('click',()=>{selectLocation(index);modal.hidden=true;document.body.classList.remove('campus-modal-open');});modalGrid.appendChild(item);});
   dialog.append(header,modalGrid);modal.appendChild(dialog);campusList?.appendChild(openButton);document.body.appendChild(modal);
   const closeModal=()=>{modal.hidden=true;document.body.classList.remove('campus-modal-open');};openButton.addEventListener('click',()=>{modal.hidden=false;document.body.classList.add('campus-modal-open');closeButton.focus();});closeButton.addEventListener('click',closeModal);modal.addEventListener('click',event=>{if(event.target===modal)closeModal();});document.addEventListener('keydown',event=>{if(event.key==='Escape'&&!modal.hidden)closeModal();});
  }
 }
 if(about&&locations.length>1&&!about.querySelector('.institution-campus-list')){
  const section=document.createElement('div'),title=document.createElement('h3'),grid=document.createElement('div');
  section.className='institution-campus-list';title.textContent='Sedes registradas';grid.className='specialty-grid';
  locations.forEach(location=>{const link=document.createElement('a'),name=document.createElement('b'),detail=document.createElement('small');link.href='https://www.google.com/maps/search/?api=1&query='+encodeURIComponent(location.address);link.target='_blank';link.rel='noopener';name.textContent='⌖ '+location.name;detail.textContent=[location.city,location.department,location.detail].filter(Boolean).join(' · ');link.append(name,document.createElement('br'),detail);grid.appendChild(link);});
  section.append(title,grid);const anchor=about.querySelector('.notice,.source-note');if(anchor)anchor.before(section);else about.appendChild(section);
 }
 const box=document.getElementById('institution-map'),points=window.institutionMapData||[],key=window.googleMapsKey;let institutionMap,routeRenderer;if(!box||!key){if(box)box.innerHTML='<div class="map-error">Configura la clave de Google Maps para visualizar esta ubicación.</div>';return;}
 window.initInstitutionMap=()=>{const map=institutionMap=new google.maps.Map(box,{center:{lat:-16.5,lng:-64.5},zoom:5,mapTypeControl:false,streetViewControl:false});const geocoder=new google.maps.Geocoder(),bounds=new google.maps.LatLngBounds(),bo=new google.maps.LatLngBounds({lat:-22.9,lng:-69.7},{lat:-9.6,lng:-57.4});let found=0,done=0,info;box.querySelector('.map-loading')?.remove();
 const finish=()=>{if(++done!==points.length)return;if(!found){box.insertAdjacentHTML('beforeend','<div class="map-error">No pudimos determinar esta ubicación con precisión. Usa “Abrir en Google Maps”.</div>');return;}map.fitBounds(bounds,55);google.maps.event.addListenerOnce(map,'idle',()=>{if(found===1||map.getZoom()>16)map.setZoom(16);});};
 const mark=(point,position,address)=>{if(!bo.contains(position))return;found++;bounds.extend(position);const marker=new google.maps.Marker({map,position,title:point.name,label:points.length>1?String(found):null});marker.addListener('click',()=>{info?.close();info=new google.maps.InfoWindow({content:`<div class="marker-info"><b>${safe(point.name)}</b><p>${safe(point.detail||address)}</p><a target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(point.address)}">Abrir esta ubicación</a></div>`});info.open({map,anchor:marker});});};
 points.forEach((point,index)=>setTimeout(()=>{if(point.latitude&&point.longitude){mark(point,new google.maps.LatLng(Number(point.latitude),Number(point.longitude)),point.address);finish();return;}geocoder.geocode({address:point.address,componentRestrictions:{country:'BO'},bounds:bo},(results,status)=>{const result=status==='OK'?results[0]:null;if(result)mark({...point,detail:[point.detail,result.geometry.location_type==='APPROXIMATE'?'Ubicación aproximada; confirma la dirección con la sede.':''].filter(Boolean).join(' · ')},result.geometry.location,result.formatted_address);finish();});},index*140));};
 const routeData=window.institutionRouteData;
 if(routeData?.enabled){
  const heading=document.querySelector('.map-heading'),external=heading?.querySelector('.map-external');
  if(heading&&external){
   const actions=document.createElement('div'),button=document.createElement('button'),status=document.createElement('p'),destinations=routeData.locations||[];let locationSelect;
   actions.className='map-actions';button.type='button';button.className='button route-activate';button.textContent='Activar recorrido';status.className='route-status';status.hidden=true;
   external.replaceWith(actions);actions.append(external);
   if(destinations.length>1){const label=document.createElement('label');locationSelect=document.createElement('select');label.className='route-location-select';label.append('ELIGE LA SEDE',locationSelect);destinations.forEach((location,index)=>{const option=document.createElement('option');option.value=String(index);option.textContent=[location.name,location.city,location.department].filter(Boolean).join(' · ');locationSelect.appendChild(option);});actions.append(label);}
   actions.append(button);heading.after(status);
   const showStatus=(message,error=false)=>{status.textContent=message;status.classList.toggle('error',error);status.hidden=false;};
   const normalize=value=>String(value||'').normalize('NFD').replace(/[\u0300-\u036f]/g,'').toLowerCase().replace(/departamento de|departamento|department/g,'').trim();
   button.addEventListener('click',()=>{
    const target=destinations[Number(locationSelect?.value||0)];
    if(!target){showStatus('No encontramos una sede disponible para calcular el recorrido.',true);return;}
    if(!navigator.geolocation){showStatus('Este navegador no permite obtener tu ubicación.',true);return;}
    button.disabled=true;button.textContent='Obteniendo ubicación…';showStatus('Autoriza el acceso a tu ubicación para comprobar el departamento.');
    navigator.geolocation.getCurrentPosition(position=>{
     if(!window.google?.maps){showStatus('Google Maps todavía está cargando. Inténtalo nuevamente.',true);button.disabled=false;button.textContent='Activar recorrido';return;}
     const origin={lat:position.coords.latitude,lng:position.coords.longitude};
     const routeGeocoder=new google.maps.Geocoder();
     routeGeocoder.geocode({location:origin},(results,geocodeStatus)=>{
      const originComponent=geocodeStatus==='OK'?results?.[0]?.address_components?.find(item=>item.types.includes('administrative_area_level_1')):null;
      const currentDepartment=normalize(originComponent?.long_name);
      if(!currentDepartment){showStatus('No pudimos identificar tu departamento con precisión. Revisa que la ubicación de Windows esté activada.',true);button.disabled=false;button.textContent='Activar recorrido';return;}
      const coordinateParts=String(target.destination||'').split(',').map(value=>Number(value.trim()));
      const destinationRequest=coordinateParts.length===2&&coordinateParts.every(Number.isFinite)?{location:{lat:coordinateParts[0],lng:coordinateParts[1]}}:{address:target.destination};
      routeGeocoder.geocode(destinationRequest,(destinationResults,destinationStatus)=>{
       const destinationComponent=destinationStatus==='OK'?destinationResults?.[0]?.address_components?.find(item=>item.types.includes('administrative_area_level_1')):null;
       const destinationDepartment=normalize(destinationComponent?.long_name);
       if(!destinationDepartment){showStatus(`No pudimos verificar el departamento de ${target.name}. El recorrido fue bloqueado por seguridad.`,true);button.disabled=false;button.textContent='Activar recorrido';return;}
       if(currentDepartment!==destinationDepartment){showStatus(`Debes estar en el mismo departamento que la sede seleccionada. Tu ubicación aparece en ${originComponent.long_name} y ${target.name} está en ${destinationComponent.long_name}.`,true);button.disabled=false;button.textContent='Activar recorrido';return;}
       showStatus('Ubicación y sede confirmadas en el mismo departamento. Calculando el recorrido…');
       const directionsService=new google.maps.DirectionsService();routeRenderer??=new google.maps.DirectionsRenderer({map:institutionMap,suppressMarkers:false});
       directionsService.route({origin,destination:target.destination,travelMode:google.maps.TravelMode.DRIVING},(routeResult,routeStatus)=>{
        if(routeStatus==='OK'){routeRenderer.setDirections(routeResult);showStatus(`Recorrido listo hacia ${target.name}. La línea azul muestra la ruta desde tu ubicación.`);box.scrollIntoView({behavior:'smooth',block:'center'});}
        else{showStatus('No pudimos calcular una ruta vehicular hasta la institución. Verifica la dirección o inténtalo nuevamente.',true);}
        button.disabled=false;button.textContent='Actualizar recorrido';
       });
      });
     });
    },error=>{const messages={1:'Debes permitir el acceso a tu ubicación para calcular el recorrido.',2:'No pudimos determinar tu ubicación actual.',3:'La ubicación tardó demasiado en responder. Inténtalo nuevamente.'};showStatus(messages[error.code]||'No pudimos acceder a tu ubicación.',true);button.disabled=false;button.textContent='Activar recorrido';},{enableHighAccuracy:true,timeout:12000,maximumAge:60000});
   });
  }
 }
 const safe=v=>String(v||'').replace(/[&<>'"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#39;','"':'&quot;'})[c]);const script=document.createElement('script');script.src=`https://maps.googleapis.com/maps/api/js?key=${encodeURIComponent(key)}&callback=initInstitutionMap&v=weekly&language=es&region=BO`;script.async=true;script.onerror=()=>box.innerHTML='<div class="map-error">Google Maps no pudo cargarse. Revisa las restricciones de la clave.</div>';document.head.appendChild(script);
})();
