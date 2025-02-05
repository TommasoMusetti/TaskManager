TaskManager (Quazar + Laravel + MySQL)

All'avvio si presenta un form di login che l'utente dovrà compilare necessariamente per poter accedere alla propria dashboard,
alternativamente può decidere di creare un nuovo account.

All'interno della dashboard è possibile effettuare diverse operazioni: - Aggiungere una nuova task - Modificare una task già esistente - Modificare lo stato di una o più task, passare da 'non conclusa' a 'conclusa' e viceversa (le task concluse sono sbarrate) - Eliminare una o più task in contemporanea

Tutte queste operazioni sono collegate ad un database che contiene gli utenti che si registrano e le varie task da loro aggiunte,
rispettivamente nelle tabelle Users e Tasks

Dalla dashboard è possibile uscirne cliccando sul pulsante Logout in alto a destra, verrete successivamente reindirizzati alla pagina di Login
