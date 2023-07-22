import{a as e,j as i,r as o,b as A,d as D,F as m,g as N,f}from"./app-848f8f6f.js";import{U as V}from"./User-d39ad514.js";import{S as d}from"./sweetalert2.all-6391f0aa.js";function W(){return e("div",{className:"bg-gray-300 bg-opacity-30 z-50 min-h-screen fixed w-full flex items-center justify-center",children:e("div",{className:"text-center",children:i("svg",{className:"animate-spin -ml-1 mr-3 h-10 w-10 mx-auto text-green-600",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",children:[e("circle",{className:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor",strokeWidth:"4"}),e("path",{className:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"})]})})})}function Q({target:u,soal:b,is_last_soal:S,csrf_token:k,is_first_soal:_}){const[a,p]=o.useState(b),[C,w]=o.useState(S),[L,j]=o.useState(_),[r,h]=o.useState(0),[P,s]=o.useState(!1),[g,B]=o.useState(null),[x,I]=o.useState(null),[n,c]=o.useState(null),v=o.useRef(null),z=()=>{if(console.log("TempSoal",a),console.log("PilihanId",r),r===0&&a.yes_no!==1)d.fire("Info!","Pilih jawaban ","info");else if(!n&&parseInt(a.yes_no)===1)d.fire("Info!","Pilih jawaban ya atau tidak","info");else{s(!0);let l={soal_id:a.id,target_id:u.id};n&&a.yes_no===1?l.pilihan_id=n:l.pilihan_id=r,l._token=k,f.post("/nextSoal",l).then(t=>{p(t.data.next_soal),w(t.data.is_last_soal),t.data.riwayatPilihan?h(t.data.riwayatPilihan.pilihan_ganda_id):(h(0),c(null)),s(!1)}).catch(t=>{s(!1),console.log("err",t)})}},R=()=>{if(console.log("PilihanId",r),r===0&&a.yes_no!==1)d.fire("Info!","Pilih jawaban ","info");else if(!n&&a.yes_no===1)d.fire("Info!","Pilih jawaban ya atau tidak","info");else if(!g)d.fire("Info!","Silahkan Upload Bersama Responden ","info");else{s(!0);const l=new FormData;l.append("soal_id",a.id),l.append("target_id",u.id),l.append("image",g),n&&a.yes_no===1?l.append("pilihan_id",n):l.append("pilihan_id",r),f.post("/nextSoal",l).then(t=>{d.fire({icon:"success",title:"Anda telah menyelesaikan survey"}),N.get("/list-survey"),s(!1)}).catch(t=>{console.log("err",t),s(!1),console.log("err",t)})}},F=()=>{v.current.click()},M=l=>{if(l.target.files.length){B(l.target.files[0]);const t=new FileReader;t.readAsDataURL(l.target.files[0]),t.onload=function(T){let $=T.target.result;I($)}}},y=()=>{s(!0),f.get(`/backSoal?soal_id=${a.id}&target_id=${u.id}`).then(l=>{p(l.data.soal),h(l.data.pilihanUser.pilihan_ganda_id),j(l.data.first_soal),w(!1),s(!1),c(null)}).catch(l=>{s(!1),console.log("err",l),c(null)})},U=()=>e(m,{children:a.pilihan.map((l,t)=>i("div",{className:`p-3 rounded-full mb-3 border flex items-center ${r===l.id?"bg-yellow-500 text-white  border-yellow-500 ":"bg-yellow-100 border-yellow-100"}`,onClick:()=>h(l.id),children:[r===l.id&&e("div",{className:"mr-2",children:e("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor",className:"w-6 h-6",children:e("path",{fillRule:"evenodd",d:"M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z",clipRule:"evenodd"})})}),i("span",{className:"mr-2 text-sm",children:[t+1,"."]}),e("span",{className:"text-sm",children:l.title})]},l.id))});return i(V,{children:[e(A,{title:`Pertanyaan ${a.title}`}),P&&e(W,{}),i("div",{className:"bg-yellow-50 min-h-screen",children:[e("div",{className:"bg-yellow-600 h-36 w-full rounded-b-3xl",children:i(D,{href:"/list-survey",className:"flex items-center px-3 pt-2",children:[e("div",{className:"text-white",children:e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",strokeWidth:1.5,stroke:"currentColor",className:"w-6 h-6",children:e("path",{strokeLinecap:"round",strokeLinejoin:"round",d:"M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"})})}),e("div",{className:"text-white ml-3",children:"Survey"})]})}),i("div",{className:"bg-white p-3 rounded-lg -mt-24 mx-3",children:[e("div",{className:"text-lg font-semibold",children:a.title}),e("div",{className:"text-sm",children:a.subtitle})]}),i("div",{className:"bg-white p-3 rounded-lg  mx-3 mt-2",children:[a.yes_no>0?i(m,{children:[i("div",{className:`p-3 rounded-full mb-3 border flex items-center ${n==="iya"?"bg-yellow-500 text-white  border-yellow-500 ":"bg-yellow-100 border-yellow-100"}`,onClick:()=>c("iya"),children:[n==="iya"&&e("div",{className:"mr-2",children:e("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor",className:"w-6 h-6",children:e("path",{fillRule:"evenodd",d:"M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z",clipRule:"evenodd"})})}),e("span",{className:"mr-2 text-sm",children:"1."}),e("span",{className:"text-sm",children:"Iya"})]}),i("div",{className:`p-3 rounded-full mb-3 border flex items-center ${n==="tidak"?"bg-yellow-500 text-white  border-yellow-500 ":"bg-yellow-100 border-yellow-100"}`,onClick:()=>c("tidak"),children:[n==="tidak"&&e("div",{className:"mr-2",children:e("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor",className:"w-6 h-6",children:e("path",{fillRule:"evenodd",d:"M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z",clipRule:"evenodd"})})}),e("span",{className:"mr-2 text-sm",children:"2."}),e("span",{className:"text-sm",children:"Tidak"})]})]}):e(U,{}),C?i(m,{children:[e("div",{onClick:F,className:"flex flex-col items-center justify-center h-32 w-full bg-gray-200 rounded-lg mt-6",children:x?e("img",{src:x,alt:"",className:"h-32 mx-auto object-contain  text-center"}):i(m,{children:[e("div",{className:"",children:i("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24",strokeWidth:1.5,stroke:"currentColor",className:"w-6 h-6",children:[e("path",{strokeLinecap:"round",strokeLinejoin:"round",d:"M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"}),e("path",{strokeLinecap:"round",strokeLinejoin:"round",d:"M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"})]})}),e("div",{className:"",children:"Foto Bersama"})]})}),e("input",{type:"file",ref:v,className:"",hidden:!0,accept:"image/*",capture:"camera",onChange:M}),e("div",{onClick:R,className:" bg-yellow-600 text-white text-center px-2 py-3 rounded-full w-full mt-10",children:"Selesai"}),e("div",{onClick:y,className:" bg-gray-600 w-full mt-4 text-white text-center px-2 py-3 rounded-full ",children:"Back"})]}):i("div",{className:"flex justify-between mt-16",children:[L?e("div",{onClick:()=>N.get("/list-survey"),className:" bg-gray-600 text-white text-center px-2 py-3 rounded-full w-1/3",children:"Back Home"}):e("div",{onClick:y,className:" bg-gray-600 text-white text-center px-2 py-3 rounded-full w-1/3",children:"Back"}),e("div",{onClick:z,className:" bg-yellow-600 text-white text-center px-2 py-3 rounded-full w-1/2",children:"Selanjutnya"})]})]})]})]})}export{Q as default};
