<div class="dash-table-area">
    <div class="dash-title"><h1 id='dash-table-title'>Exams List</h1></div>
    <div class="dash-searchbar">
        <div class="searchbar-select searchbar-element">
            <select name="resultsAmount" id='results-amount' onchange="updateDisplayAmount()">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="-1">All</option>
            </select>
            <p id='records-text'>records per page</p>
        </div>
        <div class="searchbar-search searchbar-element">
            <p id='search-text'>Search: </p>
            <input type="text" id='dash-search-input' onkeyup='onSearch()'>
        </div>
    </div>
    <div class="dash-table-div">
        <p class="disabled" id='table-empty-records'>No records</p>
        <table id='table'><script> loadTables(); </script></table>
        <div class="table-legend">
            <div class="legend-text">
                <p id='table-display-legend'></p>
            </div>
            <div class="legend-buttons" id='legend-buttons-container'></div>
        </div>
    </div>
</div>