
<form id="payment" class="form-horizontal" method="POST" action="index.php?route=payment/klarna_invoice/send">
  <fieldset>
    <legend>Add Klarna</legend>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-dob">entry_dob</label>
      <div class="col-sm-3">
        <select name="pno_day" id="input-dob" class="form-control">
          <option value="">text_day</option>
    
          <option value="07">07</option>
     
        </select>
      </div>
      <div class="col-sm-3">
        <select name="pno_month" class="form-control">
          <option value="">text_month</option>

          <option value="07">07</option>
     
        </select>
      </div>
      <div class="col-sm-3">
        <select name="pno_year" class="form-control">
          <option value="">text_year</option>

          <option value="1960">1960</option>
 
        </select>
      </div>
    </div>		
    <div class="form-group required">
      <label class="col-sm-2 control-label">entry_gender</label>
      <div class="col-sm-10">
        <label class="radio-inline">
          <input type="radio" name="gender" value="1" checked />
          Male</label>
        <label class="radio-inline">
          <input type="radio" name="gender" value="0" />
          Female</label>
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-street">Street</label>
      <div class="col-sm-10">
        <input type="text" name="street" value="Hellersbergstraße" id="input-street" class="form-control" />
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-house-no">entry_house_no</label>
      <div class="col-sm-10">
        <input type="text" name="house_no" value="14" id="input-house-no" class="form-control" />
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-phone-no">Phone</label>
      <div class="col-sm-10">
        <input type="text" name="phone_no" value="01522113356" id="input-phone-no" class="form-control" />
      </div>
    </div>
    <div class="radio">
      <input type="checkbox" name="deu_terms" value="1" checked />
      Mit der Ubermittlung der fur die Abwicklung des Rechnungskaufes und einer Identitats - und Bonitatsprufung erforderlichen
      Daten an Klarna bin ich einverstanden. Meine <a href="https://online.klarna.com/consent_de.yaws" target="_blank">Einwilligung</a> kann ich jederzeit mit Wirkung fur die Zukunft widerrufen. </div>
  <div class="buttons">
  <div class="pull-right">
    <input type="submit" value="button_confirm" id="button-confirm" class="btn btn-primary" />
  </div>
</div>
  </fieldset>
</form>