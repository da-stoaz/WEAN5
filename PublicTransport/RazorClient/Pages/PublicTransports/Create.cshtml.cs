
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using PublicTransport.Entities;
using System.Text.Json;


namespace PublicTransport.Pages.PublicTransports
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
        public PublicTransportE PublicTransport { get; set; } = default!;

        // For more information, see https://aka.ms/RazorPagesCRUD.
        public async Task<IActionResult> OnPostAsync()
        {
            if (!ModelState.IsValid)
            {
                return Page();
            }

            var httpClient = _httpClientFactory.CreateClient("PublicTransportApi"); // Use the named client

            // Serialize the PublicTransport object to JSON
            var jsonContent = JsonSerializer.Serialize(PublicTransport);
            var content = new StringContent(jsonContent, System.Text.Encoding.UTF8, "application/json");

            // Make the POST request to the API
            var response = await httpClient.PostAsync("api/PublicTransport", content);

            if (response.IsSuccessStatusCode)
            {
                return RedirectToPage("./Index");
            }
            else
            {
                ModelState.AddModelError(string.Empty, "An error occurred while creating the public transport entry via the API.");
                return Page();
            }
        }
    }
}