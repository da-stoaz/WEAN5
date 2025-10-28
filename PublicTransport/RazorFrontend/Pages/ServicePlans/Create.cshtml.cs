using System.Text.Json;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using PublicTransport.Entities;

namespace RazorFrontend.Pages.ServicePlans
{
    public class CreateModel : PageModel
    {
        private readonly IHttpClientFactory _httpClientFactory;

        public CreateModel(IHttpClientFactory httpClientFactory)
        {
            _httpClientFactory = httpClientFactory;
        }

        public IActionResult OnGet()
        {
            return Page();
        }

        [BindProperty]
        public ServicePlan ServicePlan { get; set; } = default!;

        // For more information, see https://aka.ms/RazorPagesCRUD.
        public async Task<IActionResult> OnPostAsync()
        {
            if (!ModelState.IsValid)
            {
                return Page();
            }
            
            var httpClient = _httpClientFactory.CreateClient("PublicTransportApi");
            // Serialize the PublicTransport object to JSON
            var jsonContent = JsonSerializer.Serialize(ServicePlan);
            var content = new StringContent(jsonContent, System.Text.Encoding.UTF8, "application/json");

            // Make the POST request to the API
            
            var res = await httpClient.PostAsync($"api/ServicePlan/1", content);

            Console.WriteLine(res.StatusCode);
            
            return RedirectToPage("./Index");
        }
    }
}
