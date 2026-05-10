import NodeCache from "node-cache";

// TTL de 5 minutos por defecto; las claves se invalidan desde Laravel al guardar/editar/eliminar autoreplies
const autoReplyCache = new NodeCache({ stdTTL: 300, checkperiod: 60 });

export default autoReplyCache;
