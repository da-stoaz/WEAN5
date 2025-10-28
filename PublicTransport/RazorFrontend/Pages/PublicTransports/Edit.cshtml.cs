using System.Text.Json;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using PublicTransport.Entities;


namespace RazorFrontend.Pages.PublicTransports
{
    public class EditModel : PageModel
    {
        private readonly IHttpClientFactory _httpClientFactory;

        public EditModel(IHttpClientFactory httpClientFactory)
        {
            _httpClientFactory = httpClientFactory;
        }

        [BindProperty]
        public PublicTransportE PublicTransport { get; set; } = default!;
        
        public IList<ServicePlan> AvailableServicePlans { get; set; } = new List<ServicePlan>();
        
        [BindProperty]
        public int SelectedServicePlanId { get; set; }

        public async Task<IActionResult> OnGetAsync(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var client = _httpClientFactory.CreateClient("PublicTransportApi");

            // Fetch the PublicTransport with its ServicePlans
            var publictransport = await client.GetFromJsonAsync<PublicTransportE>($"api/PublicTransport/{id}");
            
            if (publictransport == null)
            {
                return NotFound();
            }
            PublicTransport = publictransport;

            // Fetch all service plans and filter for unassigned ones
            var allServicePlans = await client.GetFromJsonAsync<List<ServicePlan>>("api/ServicePlan");
            if (allServicePlans != null)
            {
                AvailableServicePlans = allServicePlans.Where(sp => sp.PublicTransportId == null).ToList();
            }
            
            return Page();
        }

        public async Task<IActionResult> OnPostAsync()
        {
            var client = _httpClientFactory.CreateClient("PublicTransportApi");

            if (!ModelState.IsValid)
            {
                // Re-fetch data if ModelState is invalid to ensure dropdowns are populated
                var allServicePlans = await client.GetFromJsonAsync<List<ServicePlan>>("api/ServicePlan");
                if (allServicePlans != null)
                {
                    AvailableServicePlans = allServicePlans.Where(sp => sp.PublicTransportId == null).ToList();
                }
                return Page();
            }

            var jsonContent = JsonSerializer.Serialize(PublicTransport);
            var content = new StringContent(jsonContent, System.Text.Encoding.UTF8, "application/json");

            var response = await client.PutAsync($"api/PublicTransport/{PublicTransport.Id}", content);

            if (!response.IsSuccessStatusCode)
            {
                // Handle API error, e.g., log it or return a specific error page
                return NotFound(); 
            }

            return RedirectToPage("./Index");
        }

        // Removed ServicePlanExists as the API handles existence checks
        // private bool PublicTransportExists(int id) { ... }
        
         public async Task<IActionResult> OnPostRemoveServicePlanAsync(int publicTransportId, int servicePlanId)
        {
            var client = _httpClientFactory.CreateClient("PublicTransportApi");

            // First, get the service plan to update its PublicTransportId
            var servicePlanToRemove = await client.GetFromJsonAsync<ServicePlan>($"api/ServicePlan/{servicePlanId}");

            if (servicePlanToRemove == null)
            {
                return NotFound();
            }

            // Set PublicTransportId to null to disassociate
            servicePlanToRemove.PublicTransportId = null; 

            var jsonContent = JsonSerializer.Serialize(servicePlanToRemove);
            var content = new StringContent(jsonContent, System.Text.Encoding.UTF8, "application/json");

            var response = await client.PutAsync($"api/ServicePlan/{servicePlanToRemove.Id}", content);

            if (!response.IsSuccessStatusCode)
            {
                // Handle API error
                return NotFound();
            }

            return RedirectToPage(new { id = publicTransportId });
        }

        public async Task<IActionResult> OnPostAddServicePlanAsync(int publicTransportId)
        {
            if (SelectedServicePlanId == 0) 
            {
                // Re-populate page data before returning
                await OnGetAsync(publicTransportId);
                ModelState.AddModelError(string.Empty, "Please select a service plan to add.");
                return Page();
            }

            var client = _httpClientFactory.CreateClient("PublicTransportApi");

            // Get the service plan to assign
            var servicePlanToAdd = await client.GetFromJsonAsync<ServicePlan>($"api/ServicePlan/{SelectedServicePlanId}");

            if (servicePlanToAdd == null)
            {
                await OnGetAsync(publicTransportId);
                ModelState.AddModelError(string.Empty, "Selected service plan not found.");
                return Page();
            }

            // Check if it's already assigned or if the assignment is incorrect
            if (servicePlanToAdd.PublicTransportId != null) 
            {
                await OnGetAsync(publicTransportId);
                ModelState.AddModelError(string.Empty, "Selected service plan is already assigned to another public transport.");
                return Page();
            }

            // Assign the PublicTransportId
            servicePlanToAdd.PublicTransportId = publicTransportId; 

            var jsonContent = JsonSerializer.Serialize(servicePlanToAdd);
            var content = new StringContent(jsonContent, System.Text.Encoding.UTF8, "application/json");

            var response = await client.PutAsync($"api/ServicePlan/{servicePlanToAdd.Id}", content);

            if (!response.IsSuccessStatusCode)
            {
                // Handle API error
                return NotFound();
            }
            
            return RedirectToPage(new { id = publicTransportId });
        }
    }
}
