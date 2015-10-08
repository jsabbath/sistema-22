/*


Documentacion de procedimientos almacenados


procedimientos almacenados:

///////////////////////////////////////////////////////////////////////
1 getRegProvCom

Extraer comuna,provincia y region con el nombre de la comuna

Datos de entrada :  nombre de comuna o parte de ella 
Datos de salida  :  nombre de comuna,provincia y region.

EJ:
 
	CALL getRegProvCom('rengo');
 
SALIDA:
rengo 	|	Cachapoal 	|	Libertador General Bernardo O'Higgins
///////////////////////////////////////////////////////////////////////

2 CALL addEstado
Inserta un nuevo estado 

CALL addEstado('Pendiente','Documento pendiente');


///////////////////////////////////////////////////////////////////////

3 CALL getUsuarioValido

 Funcion para el inicio de sesion 

 Datos de entrada : login y contraseña
 Datos de salida  : nombre de usuario, contraseña , id empresa por defecto y su nombre

 EJ :
 call getUsuarioValido('gdanilo','8bed39519198dc7909d49ef80ff6aff8');
 SALIDA :
 Guillermo Farias   |	8bed39519198dc7909d49ef80ff6aff8    | 	2   |	Empresa de ejemplo 2


////////////////////////////////////////////////////////////////////////

4 getEmpListadoInicio

Entrega el listado de empresas a las que pertenece un usuario descartando una que se entrega como parametro

Datos de entrada : id empresa a descartar,id usuario
Datos de salida  : id ,nombre y defecto de las empresas disponibles para el usuario 

EJ :

   call getEmpListadoInicio(1,1);    -- id empresa a descartar = 1 , id usuario = 1
SALIDA DE EMPRESAS DISPONIBLES:

2	|   Empresa de ejemplo2	|  0
///////////////////////////////////////////////////////////////////////

VISTA
VistaFacturas    
select
d.iddocumento as iddocumento,
d.ndoc as ndoc,
d.tipo as tipo,
d.clieprove as clieprove_id,
cp.nombre as clieprove_nombre,
d.fecha_reg as fecha_reg,
d.fecha_doc as fecha_doc,
d.fecha_plazo as fecha_plazo,
d.usuario_reg as usuario_reg_id,
u.nombre as usuario_reg_nombre,
d.empresa as empresa_id,
e.nombre as empresa_nombre,
d.glosa as glosa,
d.neto as neto,
d.iva as iva,
d.total as total,
d.estado as estado
from documento d inner join clieprove cp on d.clieprove=cp.id
inner join usuario u on d.usuario_reg=u.idusuario
inner join empresa e on d.empresa=e.idempresa


vista de archivos
select 
a.idadjunto as id
,a.documento,
d.ndoc as numero,
p.rut as prove_rut,
p.nombre as prove_nombre,
e.idempresa,
e.nombre as nombre_empresa,
a.usuario as idusuario,
u.nombre as nombre_usuario,
a.comentario,a.archivo,
a.tipo,
a.estado 
from adjunto a 
inner join usuario u on a.usuario = u.idusuario 
inner join documento d on d.iddocumento=a.documento 
inner join proveedor p on d.proveedor = p.idproveedor 
inner join empresa e on e.idempresa=d.empresa


vista clieprove
5  */