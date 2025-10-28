using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using PublicTransport.Entities;
using System.Net.Http.Json; // Added for GetFromJsonAsync
using System.Text.Json; // Added for JsonSerializer


namespace PublicTransport.Pages.ServicePlans
{
    public class EditModel : PageModel
    {
        private readonly IHttpClientFactory _httpClientFactory;

        public EditModel(IHttpClientFactory httpClientFactory) // Modified constructor
        {
            _httpClientFactory = httpClientFactory;
        }

        [BindProperty]
        public ServicePlan ServicePlan { get; set; } = default!;

        public async Task<IActionResult> OnGetAsync(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var client = _httpClientFactory.CreateClient("PublicTransportApi");
            var serviceplan = await client.GetFromJsonAsync<ServicePlan>($"api/ServicePlan/{id}");

            if (serviceplan == null)
            {
                return NotFound();
            }
            ServicePlan = serviceplan;
            return Page();
        }

        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more information, see https://aka.ms/RazorPagesCRUD.
        public async Task<IActionResult> OnPostAsync()
        {
            if (!ModelState.IsValid)
            {
                return Page();
            }

            var client = _httpClientFactory.CreateClient("PublicTransportApi");
            var jsonContent = JsonSerializer.Serialize(ServicePlan);
            var content = new StringContent(jsonContent, System.Text.Encoding.UTF8, "application/json");

            var response = await client.PutAsync($"api/ServicePlan/{ServicePlan.Id}", content);

            if (!response.IsSuccessStatusCode)
            {
                // In a real application, you might want to handle specific error codes
                // or log the issue, and provide more user-friendly feedback.
                return NotFound(); 
            }

            return RedirectToPage("./Index");
        }
    }
}
