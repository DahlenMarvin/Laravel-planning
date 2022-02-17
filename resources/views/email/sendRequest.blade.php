<div style="max-width: 740px" >
    <div>
        @if($typeDemande == "conges")
            <td> <h3>Nouvelle demande de congés </h3></td>
        @else
            <td> <h3>Nouvelle demande de recupération </h3> </td>
        @endif
    </div>
    <br><br>
    <div style="border-radius: 5px; text-align: center">
       <table border="0" cellpadding="0" cellspacing="0" width="100%" height="400px" style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; border-radius:5px; background-color: rgb(240, 240, 240);">
           <tr style="background-color: #4aa0e6 ; color: white">
              <th colspan ="2" > {{$employee->name . ' ' . $employee->lastname}} ({{ $poste }} | {{ \App\User::find($employee->user_id)->name }})</th>
          </tr>
          <tr height="100px">
             <td style="text-align: center; "> Semaine N°{{$nSemaine}} </td>
             @if($typeDemande == "conges")
                  <td> Demande de congés </td>
             @else
                  <td> Demande de recupération </td>
             @endif
         </tr>
         <tr>
              <td colspan="2"> Demande :<br>{{$comment}} </td>
          </tr>
       </table>
    </div>
</div>
