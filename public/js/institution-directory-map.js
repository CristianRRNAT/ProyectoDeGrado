(() => {
 const modal=document.querySelector("[data-directory-map-modal]"),openButton=document.querySelector("[data-directory-map-open]");
 if(!modal||!openButton)return;
 const closeButton=modal.querySelector("[data-directory-map-close]"),select=modal.querySelector("[data-directory-map-department]"),canvas=modal.querySelector("[data-directory-map-canvas]"),status=modal.querySelector("[data-directory-map-status]");
 const locations=Array.isArray(window.directoryInstitutionMapData)?window.directoryInstitutionMapData:[],key=window.directoryGoogleMapsKey;
 let map,geocoder,infoWindow,markers=[],loadingPromise;
 const safe=value=>String(value||"").replace(/[&<>"']/g,character=>({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"})[character]);
 const loadGoogle=()=>{
  if(window.google?.maps)return Promise.resolve();
  if(loadingPromise)return loadingPromise;
  loadingPromise=new Promise((resolve,reject)=>{
   if(!key){reject(new Error("missing-key"));return;}
   const callback="initDirectoryGoogleMap_"+Date.now();
   window[callback]=()=>{delete window[callback];resolve();};
   const script=document.createElement("script");script.src="https://maps.googleapis.com/maps/api/js?key="+encodeURIComponent(key)+"&callback="+callback+"&v=weekly";script.async=true;script.defer=true;script.onerror=reject;document.head.appendChild(script);
  });
  return loadingPromise;
 };
 const initialize=async()=>{
  if(map)return;
  await loadGoogle();canvas.replaceChildren();
  map=new google.maps.Map(canvas,{center:{lat:-16.55,lng:-64.70},zoom:5,mapTypeControl:false,streetViewControl:false,fullscreenControl:true});
  geocoder=new google.maps.Geocoder();infoWindow=new google.maps.InfoWindow();
 };
 const clearMarkers=()=>{markers.forEach(marker=>marker.setMap(null));markers=[];infoWindow?.close();};
 const popup=item=>'<div class="directory-marker-popup"><b>'+safe(item.institution)+'</b><span>'+safe([item.label,item.city,item.department].filter(Boolean).join(" · "))+'</span><small>'+safe(item.address)+'</small><a href="/instituciones/'+encodeURIComponent(item.slug)+'">Ver institución</a></div>';
 const cacheKey=item=>"orientabo_google_geo_"+item.slug+"_"+String(item.label||item.city||"sede").replace(/\s+/g,"_");
 const locate=item=>new Promise(resolve=>{
  if(item.latitude&&item.longitude){resolve({lat:Number(item.latitude),lng:Number(item.longitude)});return;}
  try{const cached=localStorage.getItem(cacheKey(item));if(cached){resolve(JSON.parse(cached));return;}}catch(_){}
  const address=[item.address,item.city,item.department,"Bolivia"].filter(Boolean).join(", ");
  geocoder.geocode({address,componentRestrictions:{country:"BO"}},(results,resultStatus)=>{
   if(resultStatus==="OK"&&results[0]){
    const point={lat:results[0].geometry.location.lat(),lng:results[0].geometry.location.lng()};
    try{localStorage.setItem(cacheKey(item),JSON.stringify(point));}catch(_){}
    resolve(point);
   }else resolve(null);
  });
 });
 const addMarker=(item,point,bounds)=>{
  const marker=new google.maps.Marker({map,position:point,title:item.institution});
  marker.addListener("click",()=>{infoWindow.setContent(popup(item));infoWindow.open({map,anchor:marker});});
  markers.push(marker);bounds.extend(point);
 };
 const showDepartment=async slug=>{
  if(!map)return;
  clearMarkers();
  if(!slug){map.setCenter({lat:-16.55,lng:-64.70});map.setZoom(5);status.textContent="Selecciona un departamento para explorar sus instituciones.";return;}
  select.disabled=true;
  const selected=locations.filter(item=>item.department_slug===slug),name=select.options[select.selectedIndex].text,bounds=new google.maps.LatLngBounds();
  status.textContent="Ubicando "+selected.length+" instituciones y sedes de "+name+"…";
  let found=0;
  for(let index=0;index<selected.length;index++){
   status.textContent="Ubicando "+(index+1)+" de "+selected.length+" instituciones de "+name+"…";
   const point=await locate(selected[index]);
   if(point){addMarker(selected[index],point,bounds);found++;}
   if(index<selected.length-1)await new Promise(resolve=>setTimeout(resolve,90));
  }
  select.disabled=false;
  if(found){map.fitBounds(bounds,55);google.maps.event.addListenerOnce(map,"bounds_changed",()=>{if(map.getZoom()>14)map.setZoom(14);});}
  else{map.setCenter({lat:-16.55,lng:-64.70});map.setZoom(5);}
  status.textContent=found+" ubicaciones mostradas de "+selected.length+" registros en "+name+".";
 };
 const open=async()=>{
  modal.hidden=false;document.body.classList.add("directory-map-open");
  try{await initialize();setTimeout(()=>google.maps.event.trigger(map,"resize"),60);await showDepartment(select.value);}
  catch(error){canvas.innerHTML="<div>No fue posible cargar Google Maps. Revisa la clave, las restricciones y tu conexión.</div>";status.textContent="Google Maps no está disponible en este momento.";}
 };
 const close=()=>{modal.hidden=true;document.body.classList.remove("directory-map-open");};
 openButton.addEventListener("click",open);closeButton.addEventListener("click",close);select.addEventListener("change",()=>showDepartment(select.value));
 modal.addEventListener("click",event=>{if(event.target===modal)close();});document.addEventListener("keydown",event=>{if(event.key==="Escape"&&!modal.hidden)close();});
})();
