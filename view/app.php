<div class="min-h-[90vh] flex justify-center items-center">
    <div class="bg-blue-400 min-h-[30vh] min-w-[50vw] py-5 px-5 rounded-2xl">
        <h2 class="text-center text-2xl">Calculate Sunrise and Sunset</h2>
        <hr>
        <div class="flex flex-1 justify-center items-center">
            <form method="POST" class="flex flex-col gap-2 py-5">
                <input class="bg-blue-300 rounded-2xl py-0.5 px-1.5" type="text" name="latitude" id="latitude" placeholder="Enter Latitude">
                <input class="bg-blue-300 rounded-2xl py-0.5 px-1.5"  type="text" name="longitude" id="longitude" placeholder="Enter longitude">
                <input class="" name="date" type="date">
                <input class="bg-blue-300 rounded-4xl w-[50%] self-center" type="submit" name="submitBtn" value="Enter">
            </form>
        </div>
        <div>
            <h2 class="text-center">Examples</h2>
            <div class="flex justify-around pb-2">
                <input class="bg-blue-300 rounded-4xl p-2" type="submit" id="FillInputsForCopenhagen" value="Copenhagen">
                <input class="bg-blue-300 rounded-4xl p-2" type="submit" id="FillInputsForKolding" value="Kolding">
            </div>
        </div>
        <hr>
        <div class="flex flex-1 justify-around">
            <?php include("includes/calculateSun.php") ?>
        </div>
    </div>
</div>

<script>
    //Code for the buttons to set predefined values to the input.
    let latitudeInput = document.querySelector("#latitude");
    let longitudeInput = document.querySelector("#longitude");

    document.querySelector("#FillInputsForCopenhagen").addEventListener("click", ()=> {
        latitudeInput.value="55.6711";
        longitudeInput.value="12.56529"
    });

        document.querySelector("#FillInputsForKolding").addEventListener("click", ()=> {
        latitudeInput.value="55.49596499900455";
        longitudeInput.value="9.46809113296381"
    });
</script>
